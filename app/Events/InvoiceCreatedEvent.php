<?php
namespace Modules\Invoice\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Invoice\Models\Invoice;

class InvoiceCreatedEvent
{
    use Dispatchable;

    public $invoice;

    /**
     * Create a new event instance.
     *
     * @param Invoice $invoice
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
}
