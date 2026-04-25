<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fournisseurs', function (Blueprint $table) {
            // Drop unwanted columns
            $table->dropColumn(['email', 'tel', 'ville', 'ice']);
    
            // You can also modify columns if needed
            // $table->string('nom')->nullable(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('fournisseurs', function (Blueprint $table) {
            // Add back the columns if you rollback
            $table->string('email')->nullable();
            $table->string('tel')->nullable();
            $table->string('ville')->nullable();
            $table->string('ice')->nullable();
        });
    }
    
};
