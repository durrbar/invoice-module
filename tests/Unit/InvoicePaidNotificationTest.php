<?php

declare(strict_types=1);

namespace Modules\Invoice\Tests\Unit;

use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Modules\Invoice\Models\Invoice;
use Modules\Notification\Notifications\InvoicePaidNotification;
use Modules\Order\Models\Order;
use Tests\TestCase;

final class InvoicePaidNotificationTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_invoice_paid_notification_sends_email()
    {
        Notification::fake();

        $order = new Order();
        $order->order_number = 'ORD-001';

        $invoice = new Invoice();
        $invoice->id = 'INV-ID-001';
        $invoice->invoice_number = 'INV-001';
        $invoice->setRelation('order', $order);

        $preferences = Mockery::mock();
        $preferences->shouldReceive('firstOrCreate')
            ->andReturn((object) [
                'database' => true,
                'email' => true,
                'sms' => false,
                'broadcast' => true,
            ]);

        $user = Mockery::mock();
        $user->id = 'user-1';
        $user->name = 'John Doe';
        $user->avatar_url = null;
        $user->shouldReceive('notificationPreferences')
            ->andReturn($preferences);

        $anonymous = new AnonymousNotifiable();

        // Trigger the notification
        $notification = new InvoicePaidNotification($invoice, $user);
        Notification::send($anonymous, $notification);

        // Assert the notification was sent via email
        Notification::assertSentTo(
            $anonymous,
            InvoicePaidNotification::class,
            function ($notification, $channels, $notifiableObject) use ($user) {
                $mailData = $notification->toMail($user);
                $rendered = (string) $mailData->render();

                return str_contains($mailData->subject, 'Invoice')
                    && str_contains($mailData->subject, 'Paid')
                    && str_contains($rendered, 'INV-001');
            }
        );
    }
}
