<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Mail\GeneralMail as MailGeneralMail;

class SecondDocumentUpload extends Notification implements ShouldQueue
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
        $subject =  __('your document has been uploaded, please dont forget to check notification panel and my ops to check on new offers you might recieve');

        if($this->lang == 'en') {
            $content = view('emails.second-document-upload-en')->render();
        } else {
            $content = view('emails.second-document-upload-es')->render();
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
            'title' =>   __('your document has been uploaded, please dont forget to check notification panel and my ops to check on new offers you might recieve'),
            'user_name' => $notifiable->name
        ];
    }

    public function retryAfter()
    {
        return 60; // Delay in seconds before the next retry
    }
}
