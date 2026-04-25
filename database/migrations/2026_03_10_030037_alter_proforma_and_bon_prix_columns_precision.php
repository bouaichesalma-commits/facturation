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
        // Bon de Livraison tables
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            $table->decimal('montant', 16, 6)->change();
        });
        Schema::table('bon_article', function (Blueprint $table) {
            $table->decimal('prix_article', 16, 6)->change();
        });
        Schema::table('custom_bon_articles', function (Blueprint $table) {
            $table->decimal('prix', 16, 6)->change();
        });

        // Facture Proforma tables
        Schema::table('facture_proformas', function (Blueprint $table) {
            $table->decimal('montant', 16, 6)->change();
        });
        Schema::table('facture_proforma_articles', function (Blueprint $table) {
            $table->decimal('prix', 16, 6)->change();
        });
        Schema::table('custom_product_facture_proforma', function (Blueprint $table) {
            $table->decimal('prix', 16, 6)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            $table->decimal('montant', 15, 2)->change();
        });
        Schema::table('bon_article', function (Blueprint $table) {
            $table->decimal('prix_article', 10, 2)->change();
        });
        Schema::table('custom_bon_articles', function (Blueprint $table) {
            $table->decimal('prix', 10, 2)->change();
        });

        Schema::table('facture_proformas', function (Blueprint $table) {
            $table->decimal('montant', 15, 2)->change();
        });
        Schema::table('facture_proforma_articles', function (Blueprint $table) {
            $table->decimal('prix', 10, 2)->change();
        });
        Schema::table('custom_product_facture_proforma', function (Blueprint $table) {
            $table->decimal('prix', 10, 2)->change();
        });
    }
};
