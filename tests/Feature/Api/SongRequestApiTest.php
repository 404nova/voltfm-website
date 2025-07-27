<?php

namespace Tests\Feature\Api;

use App\Models\SongRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SongRequestApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_submit_a_song_request()
    {
        $requestData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'artist' => 'Test Artist',
            'song_title' => 'Test Song',
            'message' => 'Test message for this song request',
        ];

        $response = $this->postJson('/api/verzoeknummer/indienen', $requestData);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Bedankt voor je verzoeknummer! We zullen het beoordelen en hopelijk binnenkort spelen.',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'request_id'
            ]);

        $this->assertDatabaseHas('song_requests', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'artist' => 'Test Artist',
            'song_title' => 'Test Song',
            'message' => 'Test message for this song request',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        $response = $this->postJson('/api/verzoeknummer/indienen', [
            'email' => 'test@example.com',
            'message' => 'Test message',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonValidationErrors(['name', 'artist', 'song_title']);
    }

    /** @test */
    public function it_accepts_a_request_without_optional_fields()
    {
        $requestData = [
            'name' => 'Test User',
            'artist' => 'Test Artist',
            'song_title' => 'Test Song',
        ];

        $response = $this->postJson('/api/verzoeknummer/indienen', $requestData);

        $response
            ->assertStatus(201)
            ->assertJson([
                'success' => true,
            ]);

        $this->assertDatabaseHas('song_requests', [
            'name' => 'Test User',
            'email' => null,
            'artist' => 'Test Artist',
            'song_title' => 'Test Song',
            'message' => null,
            'status' => 'pending',
        ]);
    }
} 