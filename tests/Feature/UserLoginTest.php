<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase; // Questo ricrea il database ad ogni test

    public function testUserCanLoginWithCorrectCredentials()
    {
        // Creiamo un utente di test
        $user = \App\Models\User::factory()->create([
            'name' => 'root',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post('/api/login', [
            'name' => 'root',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCannotLoginWithIncorrectCredentials()
    {
        $response = $this->post('/api/login', [
            'name' => 'root',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
        $response->assertSessionHasErrors();
        $this->assertGuest();  // Assert that no user is authenticated
    }
}
