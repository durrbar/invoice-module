<?php

namespace Modules\Invoice\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Invoice\Observers\InvoiceObserver;

// use Modules\Invoice\Database\Factories\InvoiceFactory;

#[ObservedBy([InvoiceObserver::class])]
class Invoice extends Model
{
    use HasFactory;
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): InvoiceFactory
    // {
    //     // return InvoiceFactory::new();
    // }

    public function order(): BelongsTo
    {
        return $this->belongsTo(config('invoice.order.model'), 'order_id', 'id');
    }
}
