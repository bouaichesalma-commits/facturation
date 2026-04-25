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
            if (!Schema::hasColumn('bon_de_livraisons', 'num')) {
                $table->string('num')->nullable()->after('id');
            }
            if (!Schema::hasColumn('bon_de_livraisons', 'montant')) {
                $table->decimal('montant', 10, 2)->default(0)->after('client_id');
            }
            if (!Schema::hasColumn('bon_de_livraisons', 'type')) {
                $table->string('type')->nullable()->after('montant');
            }
            if (!Schema::hasColumn('bon_de_livraisons', 'remise')) {
                $table->decimal('remise', 8, 2)->default(0)->after('type');
            }
            if (!Schema::hasColumn('bon_de_livraisons', 'etat_id')) {
                $table->unsignedBigInteger('etat_id')->nullable()->after('remise');
            }
            if (!Schema::hasColumn('bon_de_livraisons', 'tva')) {
                $table->boolean('tva')->default(true)->after('etat_id');
            }
            if (!Schema::hasColumn('bon_de_livraisons', 'taux')) {
                $table->decimal('taux', 5, 2)->default(20)->after('tva');
            }
    
            // Optional: remove old columns no longer needed
            if (Schema::hasColumn('bon_de_livraisons', 'montant_total')) {
                $table->dropColumn('montant_total');
            }
            if (Schema::hasColumn('bon_de_livraisons', 'etat_paiement')) {
                $table->dropColumn('etat_paiement');
            }
        });
    }
    
    public function down()
    {
        Schema::table('bon_de_livraisons', function (Blueprint $table) {
            $table->dropColumn(['num', 'montant', 'type', 'remise', 'etat_id', 'tva', 'taux']);
    
            // Optional: restore dropped columns
            $table->decimal('montant_total', 10, 2)->nullable();
            $table->string('etat_paiement')->nullable();
        });
    }
    
};
