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
        Schema::table('bon_de_commandes', function (Blueprint $table) {
            if (!Schema::hasColumn('bon_de_commandes', 'etat')) {
                $table->string('etat')->default('0');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bon_de_commandes', function (Blueprint $table) {
            if (Schema::hasColumn('bon_de_commandes', 'etat')) {
                $table->dropColumn('etat');
            }
        });
    }
};
