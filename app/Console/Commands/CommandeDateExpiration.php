<?php

namespace App\Console\Commands;

use App\Mail\sendNotificationMail;
use App\Models\Client;
// use App\Notifications\EventExpiredNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CommandeDateExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:commande-date-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = Client::where('DateExpiration', '<=', now())->where('is_Expiration','=', 0)->get();
        // 
        foreach($client as $cls){
            Mail::to('notification@facture.heberweb.com')->send(new sendNotificationMail($cls));
        }
        
            Client::where('DateExpiration', '<=', now())->where('is_Expiration','=', 0)->update([
                "is_Expiration" => 1
            ]);
        
    }
}
 
