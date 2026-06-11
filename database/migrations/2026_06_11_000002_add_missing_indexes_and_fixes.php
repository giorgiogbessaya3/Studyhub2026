<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Index user_id sur questions (requêtes dashboard fréquentes)
        Schema::table('questions', function (Blueprint $table) {
            $table->index('user_id');
        });

        // Index user_id sur reponses
        Schema::table('reponses', function (Blueprint $table) {
            $table->index('user_id');
        });

        // Index statut + ordre sur contenus
        Schema::table('contenus', function (Blueprint $table) {
            $table->index('chapitre_id');
            $table->index('ordre');
        });

        // Index created_at sur quiz_resultats (tri dashboard)
        Schema::table('quiz_resultats', function (Blueprint $table) {
            $table->index('created_at');
        });

        // Corriger onDelete manquant sur quizzes.created_by
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->foreign('created_by')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });

        // Supprimer l'ancienne table password_resets (remplacée par password_reset_tokens)
        Schema::dropIfExists('password_resets');
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('reponses', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });

        Schema::table('contenus', function (Blueprint $table) {
            $table->dropIndex(['chapitre_id']);
            $table->dropIndex(['ordre']);
        });

        Schema::table('quiz_resultats', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->foreign('created_by')->references('id')->on('users');
        });
    }
};
