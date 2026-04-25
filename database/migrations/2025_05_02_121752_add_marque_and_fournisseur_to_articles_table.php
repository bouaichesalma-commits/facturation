<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger('marque_id')->nullable()->after('id');
            $table->unsignedBigInteger('fournisseur_id')->nullable()->after('marque_id');
    
            $table->foreign('marque_id')->references('id')->on('marques')->onDelete('set null');
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['marque_id']);
            $table->dropForeign(['fournisseur_id']);
            $table->dropColumn(['marque_id', 'fournisseur_id']);
        });
    }
    
};
