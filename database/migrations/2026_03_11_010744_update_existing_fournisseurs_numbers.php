<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Fournisseur;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $fournisseurs = Fournisseur::orderBy('id', 'asc')->get();
        
        foreach ($fournisseurs as $index => $fournisseur) {
            $fournisseur->num = (string)($index + 1);
            $fournisseur->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 
    }
};
