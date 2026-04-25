<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bon_article', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bon_de_livraison_id');
            $table->unsignedBigInteger('article_id');
            $table->integer('quantite')->default(1);
            $table->decimal('prix_article', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('bon_de_livraison_id')->references('id')->on('bon_de_livraisons')->onDelete('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bon_article');
    }
};
