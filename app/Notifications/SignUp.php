<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Mail\GeneralMail as MailGeneralMail;

class SignUp extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user_obj;

    public function __construct($user_obj)
    {
        $this->user_obj = $user_obj;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }
    
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    /*  public function toMail($notifiable)
    {
        $subject =  __('Awaiting approval or non approval of account');

        if(app()->getLocale() == 'en') {
            $content = view('emails.sign-up-en')->render();
        } else {
            $content = view('emails.sign-up-es')->render();
        }
    
        return (new MailGeneralMail($subject, $content, $notifiable->name))->to($notifiable->email);
    } */

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' =>   __("New User {$this->user_obj->email} Signs Up"),
            'name' => $this->user_obj->name,
            'email' => $this->user_obj->email
        ];
    }

    public function retryAfter()
    {
        return 60; // Delay in seconds before the next retry
    }
}
