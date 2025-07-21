<?php

namespace Modules\Invoice\Tests\Unit;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Modules\Invoice\Notifications\InvoicePaidNotification;
use Tests\TestCase;

class InvoicePaidNotificationTest extends TestCase
{
    public function test_invoice_paid_notification_sends_email()
    {
        Notification::fake();

        // Mocking the invoice and notifiable
        $invoice = (object) ['id' => 123];
        $notifiable = (object) ['name' => 'John Doe', 'email' => 'john.doe@example.com'];

        // Trigger the notification
        $notification = new InvoicePaidNotification($invoice);
        Notification::send(new AnonymousNotifiable(), $notification);

        // Assert the notification was sent via email
        Notification::assertSentTo(
            new AnonymousNotifiable(),
            InvoicePaidNotification::class,
            function ($notification, $channels, $notifiableObject) use ($notifiable) {
                $mailData = $notification->toMail($notifiable);

                return $mailData->subject === 'Invoice Paid' &&
                       str_contains($mailData->render(), 'Your invoice #123 has been paid successfully.');
            }
        );
    }
}
