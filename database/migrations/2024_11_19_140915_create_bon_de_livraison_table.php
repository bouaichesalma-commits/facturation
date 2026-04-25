<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bon_de_livraisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade'); // Assurez-vous que la table `clients` existe
            $table->string('objectif');
            $table->date('date');
            $table->decimal('montant_total', 10, 2);
            $table->enum('etat_paiement', ['payé', 'non payé', 'partiellement payé'])->default('non payé');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bon_de_livraison');
    }
};
