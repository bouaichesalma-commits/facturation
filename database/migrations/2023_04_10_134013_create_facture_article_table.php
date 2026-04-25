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
        if (!Schema::hasTable('facture_article')) {
            Schema::create('facture_article', function (Blueprint $table) {
                $table->unsignedBigInteger('facture_id');
                $table->unsignedBigInteger('article_id');
                $table->foreign('facture_id')->references('id')->on('factures')->onDelete('cascade');
                $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
                $table->primary(['facture_id', 'article_id']);
                $table->integer("quantity")->default(1);
                $table->integer('delai')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facture_article');
    }
};
