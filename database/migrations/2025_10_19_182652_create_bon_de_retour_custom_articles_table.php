<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('retour_custom_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bon_de_retour_id')->constrained('bon_de_retour')->onDelete('cascade');
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('prix', 10, 2);
            $table->integer('insertion_order')->default(0);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('retour_custom_articles');
    }
};
