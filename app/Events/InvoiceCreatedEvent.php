<?php

declare(strict_types=1);

namespace Modules\Invoice\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Invoice\Models\Invoice;

class InvoiceCreatedEvent
{
    use Dispatchable;

    /**
     * Create a new event instance.
     */
    public function __construct(public readonly Invoice $invoice) {}
}
