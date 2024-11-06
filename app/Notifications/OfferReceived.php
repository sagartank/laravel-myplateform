<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Mail\GeneralMail as MailGeneralMail;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OfferReceived extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $operation_number;


    public function __construct($operation_number)
    {
        $this->operation_number = $operation_number;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $subject = 'OFFER RECEIVED';

        $data['operation_number'] = $this->operation_number;

        $content = view('emails.offer-received', $data)->render();
                    
        return (new MailGeneralMail($subject, $content, $notifiable->name))->to($notifiable->email);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'OFFER RECEIVED',
            'user_name' => $notifiable->name
        ];
    }
    
    public function retryAfter()
    {
        return 60; // Delay in seconds before the next retry
    }
}
