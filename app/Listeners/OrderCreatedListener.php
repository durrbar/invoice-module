<?php

declare(strict_types=1);

namespace Modules\Invoice\Listeners;

use Modules\Invoice\Services\InvoiceService;
use Modules\Order\Events\OrderCreatedEvent;

class OrderCreatedListener
{
    private InvoiceService $invoiceService;

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
