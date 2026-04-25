<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bon_de_sortie', function (Blueprint $table) {
            // First drop the existing foreign key
            $table->dropForeign(['client_id']);

            // Then add a new one with cascade on delete
            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('bon_de_sortie', function (Blueprint $table) {
            // Drop the cascade version
            $table->dropForeign(['client_id']);

            // Recreate the original version (without cascade)
            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients');
        });
    }


};
