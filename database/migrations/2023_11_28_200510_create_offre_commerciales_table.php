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
        Schema::create('offre_commerciales', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('num');
            $table->date('date');
            $table->string('objectif', 255)->nullable();
            $table->unsignedBigInteger('client_id');
            $table->string('tva')->nullable();
            $table->integer('taux')->nullable();
            $table->integer('Remise')->nullable();
            $table->boolean('etat')->default(0);
            $table->float('montant');
            $table->integer('delai')->nullable();
            $table->boolean('type')->default(0);

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offre_commerciales');
    }
};
