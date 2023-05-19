<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/api/v1/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Ii123465/',
            'password_confirmation' => 'Ii123465/',
            'agree'=>true
        ]);

        //$this->assertAuthenticated();
        //$response->assertNoContent();

        $response->assertStatus(200);
        $response->assertJsonFragment(['code'=>201]);
    }
}
