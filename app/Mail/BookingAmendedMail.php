<?php

declare(strict_types=1);

namespace App\Mail;

use App\Services\Constant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingAmendedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var mixed[]
     */
    protected array $bookingData;


    /**
     * @param mixed[] $bookingData
     */
    public function __construct(
        array $bookingData,
    ) {
        $this->bookingData = $bookingData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: Constant::AMENDMENT_EMAIL_SUBJECT,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-amended',
            text: 'emails.plaintext.booking-amended-text',
            with: ['bookingData' => $this->bookingData],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
