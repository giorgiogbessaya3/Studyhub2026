// database/migrations/xxxx_xx_xx_create_epreuve_classe_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpreuveClasseTable extends Migration
{
    public function up()
    {
        Schema::create('epreuve_classe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('epreuve_id')->constrained()->onDelete('cascade');
            $table->foreignId('classe_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['epreuve_id', 'classe_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('epreuve_classe');
    }
}