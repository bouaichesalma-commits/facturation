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
        Schema::create('bon_de_commandes', function (Blueprint $table) {
            $table->id();
            $table->string('num');
            $table->date('date');
            
            $table->unsignedBigInteger('client_id')->nullable();
            
            $table->string('tva')->nullable();
            $table->integer('taux')->nullable();
            $table->string('etatremise')->default('off');
            $table->float('remise')->default(0);
            $table->float('montant');
            $table->boolean('etat')->default(0);
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_de_commandes');
    }
};
