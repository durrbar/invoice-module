<?php

namespace Modules\Invoice\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InvoicePaidNotification extends Notification
{
    use Queueable;

    protected $invoice;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Invoice Paid')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your invoice #' . $this->invoice->id . ' has been paid successfully.')
            ->line('Thank you for your timely payment!')
            ->action('View Invoice', url('/invoices/' . $this->invoice->id))
            ->line('If you have any questions, feel free to contact us.');
    }
}
