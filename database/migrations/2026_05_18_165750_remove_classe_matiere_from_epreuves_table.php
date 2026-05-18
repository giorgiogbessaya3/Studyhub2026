// database/migrations/xxxx_xx_xx_remove_classe_matiere_from_epreuves_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveClasseMatiereFromEpreuvesTable extends Migration
{
    public function up()
    {
        Schema::table('epreuves', function (Blueprint $table) {
            $table->dropForeign(['classe_id']);
            $table->dropForeign(['matiere_id']);
            $table->dropColumn(['classe_id', 'matiere_id']);
        });
    }

    public function down()
    {
        Schema::table('epreuves', function (Blueprint $table) {
            $table->foreignId('classe_id')->nullable()->constrained();
            $table->foreignId('matiere_id')->nullable()->constrained();
        });
    }
}