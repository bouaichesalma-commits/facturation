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
        Schema::create('bon_commande_fournisseurs', function (Blueprint $table) {
            $table->id();

            $table->string('num')->unique();
            $table->date('date');

            // Link to Supplier
            $table->foreignId('fournisseur_id')
                  ->nullable()
                  ->constrained('fournisseurs')
                  ->nullOnDelete();

            // Totals (use decimal instead of double)
            $table->decimal('montant', 15, 2)->default(0);      // Total HT
            $table->decimal('tva', 15, 2)->default(0);          // TVA amount
            $table->decimal('taux', 5, 2)->default(20);         // TVA rate %

            $table->decimal('remise', 15, 2)->default(0);       // Discount value
            $table->string('etatremise')->nullable();

            // Status
            $table->unsignedTinyInteger('etat')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_commande_fournisseurs');
    }
};
