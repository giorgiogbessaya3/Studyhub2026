<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_resultats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('score')->default(0);
            $table->json('reponses')->nullable();
            $table->integer('temps_ecoule')->default(0);
            $table->timestamp('termine_le')->nullable();
            $table->timestamps();
            
            $table->index(['quiz_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_resultats');
    }
};