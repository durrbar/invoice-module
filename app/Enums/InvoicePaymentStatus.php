<?php

declare(strict_types=1);

namespace Modules\Invoice\Enums;

enum InvoicePaymentStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Failed = 'failed';
}
