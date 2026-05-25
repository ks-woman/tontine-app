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
        Schema::create('cotisations', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 12, 2);
            $table->date('date');
            $table->foreignId('membre_id')->constrained('membres');
            $table->foreignId('tontine_id')->constrained()->onDelete('cascade');
            $table->unique(['membre_id', 'tontine_id', 'date']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotisations');
    }
};
