<?php

namespace Tests\Feature;

use App\Models\Membre;
use App\Models\Tour;
use App\Models\User;
use Tests\TestCase;

class MembreDashboardTest extends TestCase
{

    public function test_membre_dashboard_does_not_crash_when_a_tour_has_no_linked_tontine(): void
    {
        $user = User::factory()->create([
            'is_admin' => false,
        ]);

        $membre = Membre::create([
            'nom' => 'Diallo',
            'prenom' => 'Moussa',
            'adresse' => 'Dakar',
            'email' => 'moussa@example.com',
            'telephone' => '771234567',
            'date_naissance' => '1990-01-01',
            'date_adhesion' => now(),
            'user_id' => $user->id,
            'lieu_naissance' => 'Dakar',
            'numero_piece_identite' => '12345',
        ]);

        Tour::create([
            'ordre' => 1,
            'membre_id' => $membre->id,
            'tontine_id' => 9999,
            'statut' => 'planifie',
            'type' => 'normal',
        ]);

        $response = $this->actingAs($user)->get(route('membre.dashboard'));

        $response->assertOk();
    }
}
