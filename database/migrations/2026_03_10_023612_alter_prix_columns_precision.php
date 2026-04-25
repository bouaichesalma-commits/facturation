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
        Schema::table('facture_article', function (Blueprint $table) {
            $table->decimal('prix', 16, 6)->change();
        });

        Schema::table('custom_facture_articles', function (Blueprint $table) {
            $table->decimal('prix', 16, 6)->change();
        });

        Schema::table('factures', function (Blueprint $table) {
            $table->decimal('montant', 16, 6)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facture_article', function (Blueprint $table) {
            $table->decimal('prix', 10, 2)->change();
        });

        Schema::table('custom_facture_articles', function (Blueprint $table) {
            $table->decimal('prix', 10, 2)->change();
        });

        Schema::table('factures', function (Blueprint $table) {
            $table->decimal('montant', 15, 2)->change();
        });
    }
};
