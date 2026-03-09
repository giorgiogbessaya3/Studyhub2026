<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contenus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapitre_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->longText('resume'); // Le texte du cours
            $table->json('images')->nullable(); // ['contenus/1/img1.jpg', ...]
            $table->json('exercices')->nullable(); // [{"question": "...", "reponse": "..."}]
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contenus');
    }
};