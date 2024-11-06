<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Mail\GeneralMail as MailGeneralMail;

class SignUpUnApproved extends Notification implements ShouldQueue
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
        $subject =  __('your account couldn’t be activated please contact us sagar tamll');

        if($this->lang == 'en') {
            $content = view('emails.sign-up-unapproved-en')->render();
        } else {
            $content = view('emails.sign-up-unapproved-es')->render();
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
            'title' =>   __('your account couldn’t be activated please contact us'),
            'user_name' => $notifiable->name
        ];
    }
}
