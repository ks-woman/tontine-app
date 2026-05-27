<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tontine;

class TontinePolicy
{
    // Vérifier si l'utilisateur peut gérer cette tontine
    public function gerer(User $user, Tontine $tontine)
    {
        $membre = $user->membre;
        if (!$membre) return false;

        // L'admin peut tout faire
        if ($user->is_admin) return true;

        // L'organisateur ou co-organisateur peut gérer
        return $tontine->estGerablePar($membre);
    }

    // Aliases pour compatibilité
    public function update(User $user, Tontine $tontine)
    {
        return $this->gerer($user, $tontine);
    }
}
