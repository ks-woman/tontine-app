<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tontine;

class TontinePolicy
{
    public function update(User $user, Tontine $tontine)
    {
        $membre = $user->membre;
        if (!$membre) return false;
        return $tontine->estGerablePar($membre);
    }

    public function manageToursAndCotisations(User $user, Tontine $tontine)
    {
        return $this->update($user, $tontine);
    }
}
