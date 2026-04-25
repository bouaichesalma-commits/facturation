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
        Schema::create('bon_de_sortie', function (Blueprint $table) {
            $table->id();
            $table->string('num')->nullable();
            $table->foreignId('client_id')->constrained('clients');
            $table->decimal('montant', 10, 2)->default(0.00);
            $table->string('type')->nullable();
            $table->decimal('remise', 8, 2)->default(0.00);
            $table->string('etatremise')->nullable();
            $table->unsignedBigInteger('etat_id')->default(0);
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
         Schema::dropIfExists('bon_de_sortie');
    }
};
