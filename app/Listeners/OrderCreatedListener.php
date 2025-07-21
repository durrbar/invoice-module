<?php

namespace Modules\Invoice\Listeners;

use Modules\Invoice\Services\InvoiceService;
use Modules\Order\Events\OrderCreatedEvent;

class OrderCreatedListener
{
    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function handle(OrderCreatedEvent $event)
    {
        $order = $event->order;

        // Create the associated invoice
        $this->invoiceService->createInvoice($order);
    }
}
