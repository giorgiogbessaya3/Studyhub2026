<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('contenu');
            $table->string('image')->nullable();
            $table->foreignId('classe_id')->constrained()->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('statut', ['en_attente', 'publiee', 'resolue', 'fermee'])->default('en_attente');
            $table->integer('views')->default(0);
            $table->integer('reponses_count')->default(0);
            $table->timestamp('derniere_reponse_at')->nullable();
            $table->timestamps();
            
            $table->index(['statut', 'created_at']);
            $table->index(['classe_id', 'matiere_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
};