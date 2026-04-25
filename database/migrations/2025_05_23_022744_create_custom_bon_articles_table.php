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
        Schema::create('custom_bon_articles', function (Blueprint $table) {
         
            $table->id();
            $table->foreignId('bon_id');
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('prix', 10, 2);
            $table->integer('insertion_order')->nullable();
            $table->timestamps();

             $table->foreign('bon_id')->references('id')->on('bon_de_livraisons')->onDelete('cascade');
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_bon_articles');
    }
};
