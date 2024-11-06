<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Mail\GeneralMail as MailGeneralMail;

class SignContractOtp extends Notification implements ShouldQueue
{
    use Queueable;

    public $tries = 5;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    
    public $lang;
    public $otp;
    public $user_type;

    public function __construct($lang, $otp, $user_type)
    {
        $this->lang = $lang;
        $this->otp = $otp;
        $this->user_type = $user_type;
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
        $data['otp'] =  $this->otp;

        $subject =  __('sign contract OTP '. $this->user_type);

        if($this->lang == 'en') {
            $content = view('emails.sign-contract-otp-en', $data)->render();
        } else {
            $content = view('emails.sign-contract-otp-es', $data)->render();
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
            'title' =>   __('Sign contract OTP is sent to Your Email'),
            // 'title' =>   __('sign contract OTP '. $this->otp),
            'user_name' => $notifiable->name
        ];
    }

    public function retryAfter()
    {
        return 60; // Delay in seconds before the next retry
    }
}
