<?php

namespace Modules\Invoice\Observers;

use Modules\Invoice\Events\InvoiceCreatedEvent;
use Modules\Invoice\Events\InvoicePaidEvent;
use Modules\Invoice\Models\Invoice;

class InvoiceObserver
{
    /**
     * Handle the Invoice "created" event.
     */
    public function created(Invoice $invoice): void
    {
        // Fire an event when an invoice is created
        event(new InvoiceCreatedEvent($invoice));
    }

    /**
     * Handle the Invoice "updated" event.
     */
    public function updated(Invoice $invoice): void
    {
        // Fire event when the invoice is marked as paid
        if ($invoice->isDirty('status') && $invoice->status === 'paid') {
            event(new InvoicePaidEvent($invoice));
        }
    }

    /**
     * Handle the Invoice "deleted" event.
     */
    public function deleted(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     */
    public function restored(Invoice $invoice): void
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     */
    public function forceDeleted(Invoice $invoice): void
    {
        //
    }
}
