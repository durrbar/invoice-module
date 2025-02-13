<?php

namespace Modules\Invoice\Listeners;

use Modules\Order\Events\OrderCreatedEvent;
use Modules\Invoice\Services\InvoiceService;

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
