<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Mail\GeneralMail as MailGeneralMail;

class SendContractFileSellerAndBuyer extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $attach_file;

    public function __construct($attach_file)
    {
        $this->attach_file = $attach_file;
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
        $subject =  __('When an offer has been approved already asking to sign contract');

        if(app()->getLocale() == 'en') {
            $content = view('emails.contract-file-seller-and-buyer-en')->render();
        } else {
            $content = view('emails.contract-file-seller-and-buyer-es')->render();
        }
        
        $emails_cc = app('common')->sendEmailCC();

        // return (new MailGeneralMail($subject, $content, $notifiable->name))->to($notifiable->email)->cc($emails_cc)->attach('https://www.gstatic.com/webp/gallery3/1.png');
        return (new MailGeneralMail($subject, $content, $notifiable->name))->to($notifiable->email)->cc($emails_cc)->attach($this->attach_file);
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
            'title' =>   __('when an offer has been approved already asking to sign contract'),
            'user_name' => $notifiable->name ?? $notifiable->email
        ];
    }

    public function retryAfter()
    {
        return 60; // Delay in seconds before the next retry
    }
}
