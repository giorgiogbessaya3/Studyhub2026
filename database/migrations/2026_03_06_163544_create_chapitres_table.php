<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapitres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained()->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->integer('ordre')->default(0);
            $table->boolean('statut')->default(true);
            $table->timestamps();
            
            // Éviter les doublons même titre pour même classe/matière
            $table->unique(['classe_id', 'matiere_id', 'titre']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapitres');
    }
};