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
        Schema::create('bon_de_retour_article', function (Blueprint $table) {

            $table->id();      
            $table->foreignId('bon_de_retour_id') ->constrained('bon_de_retour') ->onDelete('cascade');
            $table->foreignId('article_id')  ->constrained('articles')->onDelete('cascade');

            $table->integer('quantite');
            $table->decimal('prix_article', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bon_de_retour_article');
    }
};
