// database/migrations/xxxx_xx_xx_create_epreuve_matiere_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpreuveMatiereTable extends Migration
{
    public function up()
    {
        Schema::create('epreuve_matiere', function (Blueprint $table) {
            $table->id();
            $table->foreignId('epreuve_id')->constrained()->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['epreuve_id', 'matiere_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('epreuve_matiere');
    }
}