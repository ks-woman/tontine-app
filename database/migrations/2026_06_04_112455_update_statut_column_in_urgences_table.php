<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('urgences', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'traitee', 'rejetee'])->default('en_attente')->change();
        });
    }

    public function down()
    {
        Schema::table('urgences', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'traitee'])->default('en_attente')->change();
        });
    }
};
