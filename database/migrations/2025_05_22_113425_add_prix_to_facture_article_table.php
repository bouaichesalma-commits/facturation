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
        Schema::table('facture_article', function (Blueprint $table) {
            $table->decimal('prix', 10, 2)->after('quantity')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('facture_article', function (Blueprint $table) {
            $table->dropColumn('prix');
        });
    }
};
