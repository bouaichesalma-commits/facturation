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
        if (!Schema::hasTable('devis_article')) {
            Schema::create('devis_article', function (Blueprint $table) {
                $table->unsignedBigInteger('article_id');
                $table->unsignedBigInteger('devis_id');
                $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
                $table->foreign('devis_id')->references('id')->on('devis')->onDelete('cascade');
                $table->primary(['devis_id', 'article_id']);
                $table->integer("quantity")->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis_article');
    }
};
