<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigratePaymentsToReglements extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:migrate-to-reglements';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing montantPaiy and numero_cheque data from factures and facture_proformas to reglements table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration for Factures...');
        $factures = \App\Models\Facture::where('montantPaiy', '>', 0)->get();
        $factureCount = 0;

        foreach ($factures as $facture) {
            // Check if it already has reglements
            if ($facture->reglements()->count() === 0) {
                \App\Models\Reglement::create([
                    'facture_id' => $facture->id,
                    'paiement_id' => $facture->paiement_id,
                    'montant' => $facture->montantPaiy,
                    'num_cheque' => $facture->numero_cheque,
                ]);
                $factureCount++;
            }
        }
        $this->info("Migrated $factureCount Factures.");

        $this->info('Starting migration for Facture Proformas...');
        $proformas = \App\Models\FactureProforma::where('montantPaiy', '>', 0)->get();
        $proformaCount = 0;

        foreach ($proformas as $proforma) {
            if ($proforma->reglements()->count() === 0) {
                \App\Models\Reglement::create([
                    'facture_proforma_id' => $proforma->id,
                    'paiement_id' => $proforma->paiement_id,
                    'montant' => $proforma->montantPaiy,
                    'num_cheque' => $proforma->numero_cheque,
                ]);
                $proformaCount++;
            }
        }
        $this->info("Migrated $proformaCount Facture Proformas.");

        $this->info('Migration completed successfully!');
    }
}
