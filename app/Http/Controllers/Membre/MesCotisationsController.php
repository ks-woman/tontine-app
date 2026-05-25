<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MesCotisationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $membre = $user->membre;

        $cotisations = $membre->cotisations()
            ->with('tontine')
            ->orderBy('date', 'desc')
            ->paginate(10);

        $total_cotise = $membre->cotisations()->sum('montant');

        return view('membre.mes_cotisations', compact('cotisations', 'total_cotise'));
    }
}
