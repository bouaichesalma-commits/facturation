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
        Schema::create('stagiaires', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nom du stagiaire
            $table->foreignId('categorie_id')->constrained('categorie_stagiaires')->onDelete('cascade'); // Lien avec la table catégorie
            $table->string('telephone')->nullable(); // Numéro de téléphone
            $table->string('email')->unique(); // Email unique
            $table->string('adresse')->nullable(); // Adresse
            $table->string('portfolio_link')->nullable(); // Lien vers le portfolio
            $table->string('cv_path')->nullable(); // Chemin du fichier CV
            $table->string('demande_stage_path')->nullable(); // Chemin du fichier demande de stage
            $table->text('description')->nullable(); // Description
            $table->timestamps(); // Date de création et mise à jour
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stagiaires');
    }
};
