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
        $table->dropColumn(['prix_achat', 'quantite']);
    });
}

public function down()
{
    Schema::table('articles', function (Blueprint $table) {
        $table->decimal('prix_achat', 8, 2)->nullable(); // Adjust type if needed
        $table->integer('quantite')->nullable(); // Adjust type if needed
    });
}

};
