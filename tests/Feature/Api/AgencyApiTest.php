<?php

namespace Tests\Feature\Api;

use App\Models\Agency;
use App\Models\Event;
use App\Models\Participate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgencyApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_agencies()
    {
        $user = User::factory()->create();
        Agency::factory()->count(3)->create();

        $response = $this->actingAs($user)->getJson('/api/agencies');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_can_get_a_single_agency()
    {
        $user = User::factory()->create();
        $agency = Agency::factory()->create();

        $response = $this->actingAs($user)->getJson('/api/agencies/' . $agency->id);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $agency->id,
            'nev' => $agency->nev,
            'cim' => $agency->cim,
            'email' => $agency->email,
            'telefon' => $agency->telefon,
        ]);
    }

    public function test_can_get_events_for_an_agency()
    {
        $user = User::factory()->create();
        $agency = Agency::factory()->create();
        Event::factory()->count(3)->create(['agency_id' => $agency->id]);

        $response = $this->actingAs($user)->getJson('/api/agencies/' . $agency->id . '/events');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_can_display_vip_users_name_and_email()
    {
        $vipUser = User::factory()->create(['is_vip' => true]);
        $normalUser = User::factory()->create(['is_vip' => false]);

        $response = $this->actingAs($vipUser)->getJson('/api/users?vip=true');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => $vipUser->name, 'email' => $vipUser->email])
            ->assertJsonMissing(['name' => $normalUser->name, 'email' => $normalUser->email]);
    }

    public function test_can_cancel_participation_for_today_events()
    {
        $user = User::factory()->create();
        $todaysEvent = Event::factory()->create(['date' => Carbon::today()]);
        $tomorrowsEvent = Event::factory()->create(['date' => Carbon::tomorrow()]);
        
        $participationToday = Participate::factory()->create(['user_id' => $user->id, 'event_id' => $todaysEvent->id, 'present' => true]);
        $participationTomorrow = Participate::factory()->create(['user_id' => $user->id, 'event_id' => $tomorrowsEvent->id, 'present' => true]);

        $this->actingAs($user)->postJson('/api/participate/cancel-today');

        $this->assertDatabaseHas('participates', ['id' => $participationToday->id, 'present' => false]);
        $this->assertDatabaseHas('participates', ['id' => $participationTomorrow->id, 'present' => true]);
    }

    public function test_can_set_status_to_expired_for_old_events()
    {
        $oldEvent = Event::factory()->create(['date' => Carbon::now()->subWeeks(4), 'status' => 1]);
        $newEvent = Event::factory()->create(['date' => Carbon::now()->subWeek(), 'status' => 1]);

        $this->postJson('/api/events/expire-old');

        $this->assertDatabaseHas('events', ['id' => $oldEvent->id, 'status' => 2]);
        $this->assertDatabaseHas('events', ['id' => $newEvent->id, 'status' => 1]);
    }
    
    public function test_can_list_agencies_with_at_least_two_events()
    {
        $user = User::factory()->create();
        $agencyWith3Events = Agency::factory()->has(Event::factory()->count(3))->create();
        $agencyWith1Event = Agency::factory()->has(Event::factory()->count(1))->create();
        
        $response = $this->actingAs($user)->getJson('/api/agencies?min_events=2');

        $response->assertStatus(200)
                 ->assertJsonFragment(['nev' => $agencyWith3Events->nev])
                 ->assertJsonMissing(['nev' => $agencyWith1Event->nev]);
    }

    public function test_vip_can_be_invited_if_space_is_available()
    {
        $admin = User::factory()->create();
        $vipGuest = User::factory()->create(['is_vip' => true]);
        $featuredEvent = Event::factory()->create(['is_featured' => true, 'max_attendees' => 5]);
        Participate::factory()->count(4)->create(['event_id' => $featuredEvent->id]);

        $this->assertDatabaseCount('participates', 4);

        $response = $this->actingAs($admin)->postJson('/api/invitations', [
            'user_id' => $vipGuest->id,
            'event_id' => $featuredEvent->id
        ]);
        
        $response->assertStatus(201);
        $this->assertDatabaseCount('participates', 5);
        $this->assertDatabaseHas('participates', ['user_id' => $vipGuest->id, 'event_id' => $featuredEvent->id]);
    }

    public function test_event_can_be_postponed_by_a_week()
    {
        $user = User::factory()->create();
        $originalDate = Carbon::create(2026, 1, 20);
        $event = Event::factory()->create(['date' => $originalDate]);
        
        $newDate = $originalDate->copy()->addWeek();

        $this->actingAs($user)->patchJson('/api/events/' . $event->id . '/postpone', ['weeks' => 1]);
        
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'date' => $newDate->toDateString()
        ]);
    }
}
