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
    Schema::table('devis_article', function (Blueprint $table) {
        $table->decimal('prix', 10, 2)->after('quantity')->nullable(); // Replace 'some_column' if needed
    });
}

public function down()
{
    Schema::table('devis_article', function (Blueprint $table) {
        $table->dropColumn('prix');
    });
}
};
