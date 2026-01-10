<?php

namespace Tests\Feature\Api;

use App\Models\Event;
use App\Models\Participate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_participants_for_an_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        Participate::factory()->count(5)->create(['event_id' => $event->id]);

        $response = $this->actingAs($user)->getJson('/api/events/' . $event->id . '/participants');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    public function test_can_get_active_events()
    {
        $user = User::factory()->create();
        Event::factory()->count(2)->create(['status' => 1]);
        Event::factory()->count(3)->create(['status' => 0]);

        $response = $this->actingAs($user)->getJson('/api/events/active');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }
}
