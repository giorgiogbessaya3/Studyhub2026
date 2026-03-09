<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('corrections', function (Blueprint $table) {
            $table->id();
            
            // Clé étrangère vers l'épreuve
            $table->foreignId('epreuve_id')->unique()->constrained()->onDelete('cascade');
            
            // Fichier de correction
            $table->string('fichier')->nullable();
            $table->string('nom_fichier_original')->nullable();
            
            // Description optionnelle de la correction
            $table->text('description')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('corrections');
    }
};