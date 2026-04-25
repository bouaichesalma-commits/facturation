<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class SendSMS extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    public function toTwilio($notifiable)
    {
    //     $twilio = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
    //     $message = $twilio->messages
    //                 ->create("+212708241283",
    //                     array(
    //                         "body"=>"Toumi Send SMS From Laravel!",
    //                         "from"=>env('TWILIO_PHONE_NUMBER')
    //                     ));
    } 
   

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        
        $channels = [];
        
        if (isset($notifiable->routes['twilio'])) {
            array_push($channels, TwilioChannel::class);
        }

        return $channels;
        // return ['twilio'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
