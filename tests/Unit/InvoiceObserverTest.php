<?php

declare(strict_types=1);

namespace Modules\Invoice\Tests\Unit;

use Illuminate\Support\Facades\Event;
use Modules\Invoice\Enums\InvoicePaymentStatus;
use Modules\Invoice\Events\InvoicePaidEvent;
use Modules\Invoice\Models\Invoice;
use Modules\Invoice\Observers\InvoiceObserver;
use Tests\TestCase;

class InvoiceObserverTest extends TestCase
{
    public function test_updated_dispatches_invoice_paid_event_when_payment_status_is_paid(): void
    {
        Event::fake();

        $invoice = new Invoice();
        $invoice->payment_status = InvoicePaymentStatus::Paid->value;

        $observer = new InvoiceObserver();
        $observer->updated($invoice);

        Event::assertDispatched(InvoicePaidEvent::class);
    }

    public function test_updated_dispatches_invoice_paid_event_when_legacy_status_is_paid(): void
    {
        Event::fake();

        $invoice = new Invoice();
        $invoice->status = InvoicePaymentStatus::Paid->value;

        $observer = new InvoiceObserver();
        $observer->updated($invoice);

        Event::assertDispatched(InvoicePaidEvent::class);
    }
}
