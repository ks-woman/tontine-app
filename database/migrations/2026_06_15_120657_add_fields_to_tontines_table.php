<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tontines', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->integer('duree_mois')->nullable(); // durée en mois (si distincte du nbr_personne)
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->decimal('montant_cotisation', 12, 2)->nullable(); // montant par cotisation (par mois)
            $table->enum('frequence', ['mensuelle', 'trimestrielle', 'semestrielle'])->default('mensuelle');
        });
    }

    public function down()
    {
        Schema::table('tontines', function (Blueprint $table) {
            $table->dropColumn(['description', 'duree_mois', 'date_debut', 'date_fin', 'montant_cotisation', 'frequence']);
        });
    }
};
