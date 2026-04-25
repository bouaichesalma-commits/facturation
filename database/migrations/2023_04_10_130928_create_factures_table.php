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
        if (!Schema::hasTable('factures')) {
            Schema::create('factures', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('num');
                $table->date('date');
                // $table->integer('delai');
                // $table->float('montant');
                $table->string('objectif', 255)->nullable();
                $table->unsignedBigInteger('client_id');
                $table->unsignedBigInteger('paiement_id');
                $table->integer('tva')->default(20);
                // $table->integer('taux')->nullable();
                $table->boolean('etat')->default(0);
                $table->float('montant');
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                $table->foreign('paiement_id')->references('id')->on('paiements')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
