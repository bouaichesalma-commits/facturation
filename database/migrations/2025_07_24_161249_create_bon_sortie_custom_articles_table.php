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
    Schema::create('bon_sortie_custom_articles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('bon_id')->constrained('bon_de_sortie')->onDelete('cascade');
    $table->string('name');
    $table->integer('quantity');
    $table->integer('prix');
    $table->integer('insertion_order')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_sortie_custom_articles');
    }
};
