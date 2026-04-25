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
    Schema::table('bon_de_livraisons', function (Blueprint $table) {
        $table->string('etatremise', 255)->nullable()->after('remise'); // Replace 'some_column' with the appropriate column name if needed
    });
}

public function down()
{
    Schema::table('bon_de_livraisons', function (Blueprint $table) {
        $table->dropColumn('etatremise');
    });
}

};
