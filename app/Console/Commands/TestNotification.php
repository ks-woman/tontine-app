<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Console\Command;

class TestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-notification {--user-id=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crée une notification de test pour un utilisateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->option('user-id');
        $user = User::find($userId);

        if (!$user) {
            $this->error("L'utilisateur avec l'ID {$userId} n'existe pas.");
            return 1;
        }

        Notification::create([
            'user_id' => $user->id,
            'titre' => '🔔 Notification de test',
            'message' => 'Ceci est une notification de test pour vérifier que le système fonctionne correctement.',
            'lien' => route('membre.dashboard'),
            'lue' => false,
        ]);

        $this->info("Notification créée avec succès pour {$user->name}!");
        return 0;
    }
}
