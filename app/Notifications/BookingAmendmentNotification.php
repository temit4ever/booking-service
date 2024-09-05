<?php

declare(strict_types=1);

namespace App\Notifications;

use AllowDynamicProperties;
use App\Mail\BookingAmendedMail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Notification;

#[AllowDynamicProperties] class BookingAmendmentNotification extends Notification
{
    use Queueable;

    /**
     * @var mixed[] $bookingData
     */
    protected array $bookingData;

    /**
     * @param mixed[] $bookingData
     */
    public function __construct(array $bookingData)
    {
        $this->bookingData = $bookingData;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(mixed $notifiable): Mailable
    {
        return (new BookingAmendedMail($this->bookingData))
            ->to($notifiable->email, ($notifiable->firstname . ' ' . $notifiable->lastname));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [];
    }
}
