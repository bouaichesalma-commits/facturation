<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Devis;
use App\Models\Facture;
use App\Models\Avoir;
use App\Models\BonDeSortie;
use App\Models\BonDeRetour;
use App\Models\BonDeLivraison;

class UpdateOldNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-old-numbers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates old numbers (num) in Devis, Factures, Avoirs, Bon De Sortie, Bon De Retour, and Bon De Livraison to the new XXXXX/YY format.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database number formatting...');

        $models = [
            'Devis' => Devis::class,
            'Facture' => Facture::class,
            'Avoir' => Avoir::class,
            'Bon De Sortie' => BonDeSortie::class,
            'Bon De Retour' => BonDeRetour::class,
            'Bon De Livraison' => BonDeLivraison::class,
        ];

        foreach ($models as $name => $modelClass) {
            $this->info("Processing {$name}...");
            $items = $modelClass::all();
            $count = 0;

            foreach ($items as $item) {
                $num = (string) $item->num;
                
                // Skip if already perfectly formatted as exactly 8 characters with a slash (e.g., 00001/26)
                if (strlen($num) === 8 && strpos($num, '/') === 5) {
                    continue;
                }

                if (strpos($num, '/') !== false) {
                     // Extracts X from '00X/YY' or similar
                     $parts = explode('/', $num);
                     $numericPart = (int)$parts[0];
                } elseif (strpos($num, '-') !== false) {
                     // Extracts X from '0000X-YY'
                     $parts = explode('-', $num);
                     $numericPart = (int)$parts[0];
                } else {
                     // Just the raw number
                     $numericPart = (int)$num;
                }
                
                // Get the 2-digit year from the date column (fallback to current year if no date)
                $dateObj = strtotime($item->date);
                $shortYear = $dateObj ? date('y', $dateObj) : date('y');
                
                // Format as XXXXX/YY (e.g., 00021/26)
                $newNum = sprintf('%05d/%s', $numericPart, $shortYear);
                
                // Update only if changed
                if ((string)$item->num !== $newNum) {
                    $item->update(['num' => $newNum]);
                    $count++;
                }
            }
            $this->info("Updated {$count} {$name} records.");
        }

        $this->info('Finished database formatting.');
    }
}
