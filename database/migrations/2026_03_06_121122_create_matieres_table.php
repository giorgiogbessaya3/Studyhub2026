<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // CHAMP IMAGE AJOUTÉ
            $table->string('couleur')->default('#2563eb');
            $table->string('icone')->default('ti-book');
            $table->boolean('statut')->default(true);
            $table->timestamps();
        });

        // Table pivot classe_matiere
        Schema::create('classe_matiere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained()->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classe_matiere');
        Schema::dropIfExists('matieres');
    }
};