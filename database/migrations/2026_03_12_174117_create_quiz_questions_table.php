<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            $table->string('titre');
            $table->enum('type', ['qcm', 'texte', 'vrai_faux'])->default('qcm');
            $table->json('options')->nullable();
            $table->text('bonne_reponse');
            $table->integer('points')->default(1);
            $table->text('explication')->nullable();
            $table->string('image')->nullable();
            $table->integer('ordre')->default(0);
            $table->timestamps();
            
            $table->index(['quiz_id', 'ordre']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('quiz_questions');
    }
};