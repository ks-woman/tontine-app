<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tontines', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant_total', 12, 2);
            $table->integer('nbr_personne');
            $table->decimal('taux', 5, 2)->nullable();
            $table->decimal('montant_taux', 12, 2)->nullable();
            $table->foreignId('organisateur_id')->constrained('membres');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tontines');
    }
};
