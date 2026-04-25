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
      Schema::create('custom_devis_articles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('devis_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->integer('quantity');
    $table->decimal('prix', 10, 2);
    $table->integer('insertion_order')->default(0);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_devis_articles');
    }
};
