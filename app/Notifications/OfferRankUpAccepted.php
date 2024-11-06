<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Mail\GeneralMail as MailGeneralMail;
use Illuminate\Notifications\Messages\BroadcastMessage;

class OfferRankUpAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user_level_name;


    public function __construct($user_level_name)
    {
        $this->user_level_name = $user_level_name;
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
        $subject = 'RANK UP OFFER ACCEPTED';

        $data['user_level_name'] = strtoupper($this->user_level_name);

        $content = view('emails.offer-rankup-accepted', $data)->render();
                    
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
            'title' => 'RANK UP OFFER ACCEPTED',
            'user_name' =>  $notifiable->name
        ];
    }
}
