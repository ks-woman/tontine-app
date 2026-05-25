<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description');
            $table->integer('duree_mois'); // durée en mois
            $table->integer('nombre_personnes');
            $table->decimal('montant_cotisation', 12, 2); // somme à cotiser par personne
            $table->foreignId('cree_par')->constrained('users')->onDelete('cascade');
            $table->date('date_limite')->nullable(); // date limite pour postuler
            $table->enum('statut', ['active', 'cloturee', 'annulee'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
