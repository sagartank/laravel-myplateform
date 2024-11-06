<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Mail\GeneralMail as MailGeneralMail;

class FlagSecondAccountWarning extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    
    public $lang;

    public function __construct($lang)
    {
        $this->lang = $lang;
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
        $subject =  __('Second account warning : this is the 2nd strike, with one more strike your account will be temporarily banned, please keep up with standard and in 30 days your flags will be erased.');

        if($this->lang == 'en') {
            $content = view('emails.flag-second-en')->render();
        } else {
            $content = view('emails.flag-second-es')->render();
        }
        
        $emails_cc = app('common')->sendEmailCC();

        return (new MailGeneralMail($subject, $content, $notifiable->name))->to($notifiable->email)->cc($emails_cc);
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
            'title' =>   __('Second account warning : this is the 2nd strike, with one more strike your account will be temporarily banned, please keep up with standard and in 30 days your flags will be erased.'),
            'user_name' => $notifiable->name
        ];
    }
}
