<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EventExpiredListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        
        $expiredEvent = $event->getExpiredEvent(); // Customize this based on your actual implementation

        // Check if the event has expired
        if (now()->greaterThan($expiredEvent->expiration_date)) {
            // Send notification
            $expiredEvent->user->notify(new \App\Notifications\EventExpiredNotification($expiredEvent));
        }
    
    }
}
