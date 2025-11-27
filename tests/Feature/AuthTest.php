<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->post('/api/register', [
            'name' => 'Test User',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ],
        ['Accept' => 'application/json']
        );

        $response->assertStatus(200);
    }

    public function test_login_with_registered_user(): void
    {
        $email = fake()->unique()->safeEmail();
        User::factory()->create([
            'name' => 'Test User',
            'email' => $email,
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/api/login', [
            'email' => $email,
            'password' => 'password123',
        ],
        ['Accept' => 'application/json']
        );

        $response->assertStatus(200);
    }
}
