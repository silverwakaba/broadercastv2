<?php

namespace App\Mail;

use App\Models\UserRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;

// implements ShouldQueue
class User2FAEmail extends Mailable implements ShouldQueue{
    use Queueable, SerializesModels;

    public $mId;

    /**
     * Create a new message instance.
     */
    public function __construct($mId){
        $this->mId = $mId;
    }

    /**
     * Get the message envelope.
     */
    public function envelope() : Envelope{
        return new Envelope(
            subject: 'Login Securely With 2FA',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content() : Content{
        $datas = UserRequest::select('token')->where('id', '=', $this->mId)->first();

        return new Content(
            view: 'mailer.2fa',
            with: [
                'routeTo' => URL::temporarySignedRoute(
                    '2fa', now()->addMinutes(5), ['id' => $datas->token]
                ),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array{
        return [];
    }
}
