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
        Schema::create('offre_commerciale_article', function (Blueprint $table) {
            
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('offre_commerciales_id');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('offre_commerciales_id')->references('id')->on('offre_commerciales')->onDelete('cascade');
            $table->primary(['offre_commerciales_id', 'article_id']);
            $table->integer("quantity")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offre_commerciale_article');
    }
};
