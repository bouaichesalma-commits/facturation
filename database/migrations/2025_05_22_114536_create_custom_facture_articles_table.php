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
        Schema::create('custom_facture_articles', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('facture_id');
            $table->string('name');
            $table->integer('quantite');
            $table->decimal('prix', 10, 2);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('facture_id')->references('id')->on('factures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_facture_articles');
    }
};
