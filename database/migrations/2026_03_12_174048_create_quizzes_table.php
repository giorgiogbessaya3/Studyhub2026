<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->foreignId('classe_id')->constrained()->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained()->onDelete('cascade');
            $table->foreignId('chapitre_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('duree')->default(30);
            $table->integer('nombre_questions')->default(0);
            $table->integer('score_passer')->default(50);
            $table->enum('statut', ['brouillon', 'publie', 'archive'])->default('brouillon');
            $table->string('image')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index(['classe_id', 'matiere_id']);
            $table->index('statut');
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
};