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
        if (!Schema::hasTable('articles')) {
            Schema::create('articles', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('designation', 255);
                $table->text('Details')->nullable();
                $table->enum('role', ['service', 'produit']);
                $table->float('prix');
                $table->integer('Quantite')->default(1);
                $table->unsignedBigInteger('categorie_id')->nullable();
                $table->unsignedBigInteger('marque_id')->nullable();
                $table->unsignedBigInteger('fournisseur_id')->nullable();
                
                $table->timestamps();

                $table->foreign('categorie_id')->references('id')->on('categorieproduits')->onDelete('set null');
                $table->foreign('marque_id')->references('id')->on('marques')->onDelete('set null');
                $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['categorie_id']);
            $table->dropForeign(['marque_id']);
            $table->dropForeign(['fournisseur_id']);
            
            $table->dropColumn(['categorie_id', 'marque_id', 'fournisseur_id']);
        });

        // If the whole table needs to be dropped (optional and conditional):
        // Schema::dropIfExists('articles');
    }
};

