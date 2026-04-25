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
        if (!Schema::hasTable('devis')) {
            Schema::create('devis', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('num');
                $table->date('date');
                
                $table->unsignedBigInteger('client_id');
                $table->string('tva')->nullable();
                $table->integer('taux')->nullable();
                $table->integer('Remise')->nullable();
                $table->boolean('etat')->default(0);
                $table->float('montant');
              

                $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
