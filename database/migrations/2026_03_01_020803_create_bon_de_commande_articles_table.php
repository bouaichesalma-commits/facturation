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
        Schema::create('bon_de_commande_articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bon_de_commande_id');
            // For catalog products
            $table->unsignedBigInteger('article_id')->nullable();
            
            // For custom products
            $table->string('produit')->nullable();
            $table->integer('quantite')->nullable();
            $table->float('prix', 8, 2)->nullable();
            
            // Foreign keys
            $table->foreign('bon_de_commande_id')->references('id')->on('bon_de_commandes')->onDelete('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_de_commande_articles');
    }
};
