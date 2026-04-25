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
            Schema::create('custom_product_facture_proforma', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facture_proforma_id');
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('prix', 10, 2);
            $table->timestamps();

            $table->foreign('facture_proforma_id')->references('id')->on('facture_proformas')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_product_facture_proforma');
    }
};
