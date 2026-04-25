<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void {
        Schema::create('avoir_article', function (Blueprint $table) {
            $table->id();
            $table->foreignId('avoir_id')->constrained('avoir')->onDelete('cascade');
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
            $table->integer('quantite')->default(1);
            $table->decimal('prix_article', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('avoir_article');
    }
};