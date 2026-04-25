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
        Schema::table('reglements', function (Blueprint $table) {
            $table->foreignId('bon_commande_fournisseur_id')
                  ->nullable()
                  ->constrained('bon_commande_fournisseurs', 'id', 'fk_regl_bcf_id')
                  ->nullOnDelete();
                  
            $table->enum('type_flux', ['entrant', 'sortant'])->default('entrant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reglements', function (Blueprint $table) {
            $table->dropForeign('fk_regl_bcf_id');
            $table->dropColumn(['bon_commande_fournisseur_id', 'type_flux']);
        });
    }
};
