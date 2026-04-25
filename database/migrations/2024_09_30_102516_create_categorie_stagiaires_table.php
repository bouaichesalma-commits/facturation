<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorieStagiairesTable extends Migration
{
    public function up()
    {
        Schema::create('categorie_stagiaires', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée
            $table->string('nom'); // Colonne pour le nom de la catégorie
            $table->text('description')->nullable(); // Colonne pour la description de la catégorie
            $table->timestamps(); // Colonnes pour les timestamps created_at et updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorie_stagiaires');
    }
}
