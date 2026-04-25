<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   
    
    public function up()
{
    Schema::table('articles', function (Blueprint $table) {
        // Changer le type de colonne
        $table->decimal('prix', 16, 2)->change(); // 16 chiffres au total, 2 après la virgule
    });
}

public function down()
{
    Schema::table('articles', function (Blueprint $table) {
        $table->decimal('prix', 8, 2)->change(); // Version de rollback
    });
}
};
