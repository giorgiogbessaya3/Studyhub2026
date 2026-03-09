<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('epreuves', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // Clés étrangères
            $table->foreignId('classe_id')->constrained()->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained()->onDelete('cascade');
            $table->foreignId('type_epreuve_id')->constrained()->onDelete('cascade');
            
            // Fichier
            $table->string('fichier')->nullable(); // chemin du fichier stocké
            $table->string('nom_fichier_original')->nullable(); // nom original pour le téléchargement
            
            // Métadonnées
            $table->integer('annee')->nullable(); // année de l'épreuve
            $table->integer('duree')->nullable(); // durée en minutes
            $table->integer('bareme')->nullable(); // barème total
            
            $table->boolean('statut')->default(true);
            $table->timestamps();
            
            // Index pour améliorer les recherches
            $table->index(['classe_id', 'matiere_id', 'type_epreuve_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('epreuves');
    }
};