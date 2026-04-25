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
        Schema::create('bon_sortie_article', function (Blueprint $table) {
            $table->id();

            $table->foreignId('bon_id')->constrained('bon_de_sortie')->onDelete('cascade');
            $table->foreignId('article_id')->nullable()->constrained('articles')->onDelete('set null');

            $table->integer('quantite');
            $table->decimal('prix_article', 10, 2);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bon_sortie_article');
    }
};
