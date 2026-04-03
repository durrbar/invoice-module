<?php

declare(strict_types=1);

namespace Modules\Invoice\Listeners;

use Modules\Invoice\Services\InvoiceService;
use Modules\Payment\Events\PaymentSuccessEvent;

class PaymentSuccessListener
{
    public function __construct(private InvoiceService $invoiceService) {}

    public function handle(PaymentSuccessEvent $event)
    {
        $payment = $event->payment;

        // Update the associated invoice status to "paid"
        $this->invoiceService->markInvoicePaid($payment->invoice);
    }
}
