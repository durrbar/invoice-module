<?php

declare(strict_types=1);

use Modules\Order\Models\Order;

return [
    'name' => 'Invoice',

    'order' => [
        'model' => env('ORDER_MODEL', Order::class),
    ],
];
