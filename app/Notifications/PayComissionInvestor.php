<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Mail\GeneralMail as MailGeneralMail;

class PayComissionInvestor extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

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
        return ['database', 'broadcast'];
        // return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    
   /*  public function toMail($notifiable)
    {
        $subject =  __('please pay comission at the moment + at 24 hrs');

        if($this->lang == 'en') {
            $content = view('emails.pay-comission-investor-en')->render();
        } else {
            $content = view('emails.pay-comission-investor-es')->render();
        }
        
        $emails_cc = app('common')->sendEmailCC();

        return (new MailGeneralMail($subject, $content, $notifiable->name))->to($notifiable->email)->cc($emails_cc);
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
            'title' =>   __('please pay comission at the moment + at 24 hrs'),
            'user_name' => $notifiable->name
        ];
    }

    public function retryAfter()
    {
        return 60; // Delay in seconds before the next retry
    }
}