<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function marquerToutLu()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->notifications()->where('lue', false)->update(['lue' => true]);
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}
