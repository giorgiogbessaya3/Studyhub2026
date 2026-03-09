<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('type_epreuves', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->string('slug')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('icone')->nullable(); // optionnel, pour une icône représentative
            $table->boolean('statut')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('type_epreuves');
    }
};