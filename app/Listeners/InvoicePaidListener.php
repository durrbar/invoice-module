<?php

namespace Modules\Invoice\Listeners;

use Illuminate\Support\Facades\Notification;
use Modules\Invoice\Events\InvoicePaidEvent;
use Modules\Invoice\Notifications\InvoicePaidNotification;

class InvoicePaidListener
{
    /**
     * Handle the event.
     */
    public function handle(InvoicePaidEvent $event): void
    {
        $invoice = $event->invoice;
        $customer = $invoice->order->customer;

        // Notify the customer about the invoice being paid
        Notification::send($customer, new InvoicePaidNotification($invoice));
    }
}
