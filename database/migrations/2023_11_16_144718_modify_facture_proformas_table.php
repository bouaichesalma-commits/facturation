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
        Schema::table('facture_proformas', function (Blueprint $table) {
            $table->string('objectif', 255)->change();
        });
        Schema::table('factures', function (Blueprint $table) {
            $table->string('objectif', 255)->change();
        });
        
        Schema::table('recu_de_paiements', function (Blueprint $table) {
            $table->string('objectif', 255)->change();
        });
        
        Schema::table('devis', function (Blueprint $table) {
            $table->string('objectif', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facture_proformas', function (Blueprint $table) {
            // If you need to reverse the changes, you can add the necessary code here
        });
    }
};
