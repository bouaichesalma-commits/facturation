<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTvaTypeInBonDeLivraisonsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            $table->string('tva')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            $table->boolean('tva')->default(true)->change();
        });
    }
}
