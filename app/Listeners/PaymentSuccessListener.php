<?php
namespace Modules\Invoice\Listeners;

use Modules\Payment\Events\PaymentSuccessEvent;
use Modules\Invoice\Services\InvoiceService;

class PaymentSuccessListener
{
    protected InvoiceService $invoiceService;

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
