<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            if (Schema::hasColumn('bon_de_livraisons', 'objectif')) {
                $table->dropColumn('objectif');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            $table->string('objectif')->nullable(); // Or adjust type as needed
        });
    }
};
