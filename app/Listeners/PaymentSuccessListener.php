<?php

declare(strict_types=1);

namespace Modules\Invoice\Listeners;

use Modules\Invoice\Services\InvoiceService;
use Modules\Payment\Events\PaymentSuccessEvent;

class PaymentSuccessListener
{
    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function handle(PaymentSuccessEvent $event)
    {
        $payment = $event->payment;

        // Update the associated invoice status to "paid"
        $this->invoiceService->markInvoicePaid($payment->invoice);
    }
}
