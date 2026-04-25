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
        if (!Schema::hasTable('agences')) {
            Schema::create('agences', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nom');
                $table->string('logo');
                $table->string('gsm');
                $table->string('fixe');
                $table->string('site');
                $table->string('email');
                $table->string('adresse');
                $table->string('ice');
                $table->string('capital');
                $table->string('compte');
                $table->string('rc');
                $table->string('if');
                $table->string('tp');
                $table->string('cnss');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agences');
    }
};
