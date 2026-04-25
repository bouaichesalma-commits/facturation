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
        Schema::create('bon_commande_fournisseur_articles', function (Blueprint $table) {
            $table->id();
            
            // Link to the main purchase order
            $table->foreignId('bon_commande_fournisseur_id')
                  ->constrained('bon_commande_fournisseurs', 'id', 'fk_bcf_articles_bcf_id')
                  ->cascadeOnDelete();

            // Link to the Article (optional, since it might be a custom item)
            $table->foreignId('article_id')
                  ->nullable()
                  ->constrained('articles')
                  ->nullOnDelete();

            $table->string('produit')->nullable();      // Product name (especially for custom items)
            $table->decimal('quantite', 10, 2);         // Quantity can sometimes have decimals (e.g. 1.5 kg)
            $table->decimal('prix', 15, 2);             // Unit price

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_commande_fournisseur_articles');
    }
};
