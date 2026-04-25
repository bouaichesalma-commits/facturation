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
    Schema::create('bon_de_retour', function (Blueprint $table) {
        $table->id();
        $table->string('num');
        $table->bigInteger('client_id')->unsigned();
        $table->decimal('montant', 15, 2);
        $table->string('type')->nullable();
        $table->decimal('remise', 8, 2)->default(0);
        $table->string('etatremise')->nullable();
        $table->bigInteger('etat_id')->nullable()->unsigned();
        $table->string('tva')->nullable();
        $table->decimal('taux', 5, 2)->default(20.00);
        $table->date('date');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_de_retour');
    }
};
