<?php

declare(strict_types=1);

namespace Modules\Invoice\Listeners;

use Modules\Invoice\Services\InvoiceService;
use Modules\Order\Events\OrderCreatedEvent;

class OrderCreatedListener
{
    public function __construct(private InvoiceService $invoiceService) {}

    public function handle(OrderCreatedEvent $event)
    {
        $order = $event->order;

        // Create the associated invoice
        $this->invoiceService->createInvoice($order);
    }
}
