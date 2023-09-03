<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BeerApiTest extends TestCase
{
    use RefreshDatabase;

    public function testBeersApiReturnsData()
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'root',
            'password' => Hash::make('password'),
        ]);

        // Autentichiamoci come l'utente
        $this->actingAs($user);

        $response = $this->get('/api/beers');
        
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     '*' => ['id', 'name', 'description'] // sostituisci con la struttura effettiva
                 ]);
    }
}
