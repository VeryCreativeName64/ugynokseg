<?php

namespace Tests\Feature\Api;

use App\Models\Event;
use App\Models\Participate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_events_for_a_user()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();
        Participate::factory()->create(['user_id' => $user->id, 'event_id' => $event->id]);

        $response = $this->actingAs($user)->getJson('/api/users/' . $user->id . '/events');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }
}
