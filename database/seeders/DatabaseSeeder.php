<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('   STUDYHUB 2026 — Seeding complet');
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('');

        $this->call([
            // ── Données de référence ──────────────────
            ClasseSeeder::class,
            MatiereSeeder::class,
            TypeEpreuveSeeder::class,
            ChapitreSeeder::class,

            // ── Utilisateurs (dépend des classes) ─────
            UserSeeder::class,

            // ── Paramètres du site ────────────────────
            SettingSeeder::class,

            // ── Contenus pédagogiques ─────────────────
            ContenuSeeder::class,
            EpreuveSeeder::class,
            QuizSeeder::class,

            // ── Interactions utilisateurs ─────────────
            AssistanceSeeder::class,
            BlogSeeder::class,

            // ── Données SVT Terminale (existantes) ────
            SVTTerminalQuizSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('   Seeding terminé avec succès !');
        $this->command->info('');
        $this->command->info('   Comptes de test :');
        $this->command->info('   admin@studyhub.test   / password123');
        $this->command->info('   prof@studyhub.test    / password123');
        $this->command->info('   eleve@studyhub.test   / password123');
        $this->command->info('   eleve2@studyhub.test  / password123');
        $this->command->info('═══════════════════════════════════════');
        $this->command->info('');
    }
}
