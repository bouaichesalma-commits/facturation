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
        Schema::table('reglements', function (Blueprint $table) {
            $table->unsignedBigInteger('facture_id')->nullable()->change();
            $table->unsignedBigInteger('facture_proforma_id')->nullable()->after('facture_id');
            $table->foreign('facture_proforma_id')->references('id')->on('facture_proformas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reglements', function (Blueprint $table) {
            $table->dropForeign(['facture_proforma_id']);
            $table->dropColumn('facture_proforma_id');
            // Reverting facture_id to non-nullable might fail if there are records with null,
            // so we'll just leave it nullable in the down method or handle it carefully.
        });
    }
};
