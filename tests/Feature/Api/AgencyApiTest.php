<?php

namespace Tests\Feature\Api;

use App\Models\Agency;
use App\Models\Event;
use App\Models\User;
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
}
