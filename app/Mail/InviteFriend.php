<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class InviteFriend extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $referral_code;
    public $referral_link;

    public function __construct($name, $referral_code, $referral_link)
    {
        $this->name = $name;
        $this->referral_code = $referral_code;
        $this->referral_link = $referral_link;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Invite Friend',
            /*
            it's working but  use for controller
            cc: [
                new Address('sagartank.w3nuts@gmail.com', 'Sagar Tank'),
            ],
            bcc: [
                new Address('sagartank.w3nuts@gmail.com', 'Sagar Tank'),
            ],
            */
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.invite-friend',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
