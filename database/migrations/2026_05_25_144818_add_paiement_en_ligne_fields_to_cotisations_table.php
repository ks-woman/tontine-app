<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->enum('mode_paiement', ['especes', 'orange_money', 'wave', 'free_money'])->default('especes');
            $table->string('reference_transaction')->nullable();
            $table->string('numero_transfert')->nullable();
            $table->string('nom_envoyeur')->nullable();
            $table->string('preuve_fichier')->nullable();
            $table->enum('statut_paiement', ['en_attente', 'confirme', 'rejete'])->default('en_attente');
        });
    }

    public function down(): void
    {
        Schema::table('cotisations', function (Blueprint $table) {
            $table->dropColumn(['mode_paiement', 'reference_transaction', 'numero_transfert', 'nom_envoyeur', 'preuve_fichier', 'statut_paiement']);
        });
    }
};
