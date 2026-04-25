<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up(): void
        {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('banque');
            });
        }

        public function down(): void
        {
            Schema::table('clients', function (Blueprint $table) {
                $table->string('banque')->nullable(); 
                // Replace 'some_existing_column' with the correct column if you want to rollback
            });
        }

};
