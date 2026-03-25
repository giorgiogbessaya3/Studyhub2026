<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ClasseSeeder::class,
            MatiereSeeder::class,
            TypeEpreuveSeeder::class,
            ChapitreSeeder::class,
            SVTTerminalQuizSeeder::class,  
            
        ]);
    }
}