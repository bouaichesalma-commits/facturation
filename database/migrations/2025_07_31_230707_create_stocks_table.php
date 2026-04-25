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
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('designation');
            $table->text('Details')->nullable();
            $table->double('prix', 8, 2);
            $table->decimal('prix_achat', 10, 2)->nullable();
            $table->integer('Quantite')->default(1);

            // Set nullable for foreign keys if you use 'set null'
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->unsignedBigInteger('marque_id')->nullable();
            $table->unsignedBigInteger('fournisseur_id')->nullable();

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('categorie_id')
                ->references('id')
                ->on('categorieproduits')
                ->onDelete('set null');

            $table->foreign('marque_id')
                ->references('id')
                ->on('marques')
                ->onDelete('set null');

            $table->foreign('fournisseur_id')
                ->references('id')
                ->on('fournisseurs')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Safely drop foreign keys before dropping table
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropForeign(['categorie_id']);
            $table->dropForeign(['marque_id']);
            $table->dropForeign(['fournisseur_id']);
        });

        Schema::dropIfExists('stocks');
    }
};
