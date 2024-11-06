<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Mail\GeneralMail as MailGeneralMail;

class OperationStatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $operation_obj;


    public function __construct($operation_obj)
    {
        $this->operation_obj = $operation_obj;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
        // return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    /* public function toMail($notifiable)
    {
        $data['operation_status'] = $this->operation_status;
        $data['operation_number'] = $this->operation_number;
        $data['operation_seller_name'] = $this->operation_seller_name;

        $subject = 'MIPO OPERATION STATUS '. $data['operation_status'];

        $emails_cc = app('common')->sendEmailCC();
        $emails_bcc = app('common')->sendEmailBCC();

        $content = view('emails.operation-status', $data)->render();
        
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
        /* return [
            'title' => '<strong>'.$this->operation_status .'</strong>',
            'user_name' =>  $notifiable->name
        ]; */

        return [
            'title' =>   __("New Operation has been created <strong> {$this->operation_obj->operation_number} </strong>"),
            'name' => $this->operation_obj->seller?->name ?? null,
            'email' => $this->operation_obj->seller?->email ?? null
        ];
    }
}
