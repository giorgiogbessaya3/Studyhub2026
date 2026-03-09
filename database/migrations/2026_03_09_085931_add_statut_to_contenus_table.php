<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  
// database/migrations/xxxx_add_statut_to_contenus_table.php

    public function up()
    {
        Schema::table('contenus', function (Blueprint $table) {
            $table->boolean('statut')->default(true)->after('ordre');
        });
    }

    public function down()
    {
        Schema::table('contenus', function (Blueprint $table) {
            $table->dropColumn('statut');
        });
    }
};
