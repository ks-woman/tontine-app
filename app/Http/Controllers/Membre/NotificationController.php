<?php

namespace App\Http\Controllers\Membre;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    // Afficher toutes les notifications
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->paginate(10);
        $nonLuesCount = $user->notifications()->where('lue', false)->count();
        return view('membre.notifications', compact('notifications', 'nonLuesCount'));
    }

    // Marquer une notification comme lue
    public function marquer($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $notification = $user->notifications()->findOrFail($id);
        $notification->update(['lue' => true]);
        return back()->with('success', 'Notification marquée comme lue.');
    }

    // Tout marquer comme lu
    public function marquerTout()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $count = $user->notifications()->where('lue', false)->update(['lue' => true]);
        return back()->with('success', "$count notification(s) marquée(s) comme lue(s).");
    }
}
