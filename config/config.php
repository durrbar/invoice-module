<?php

return [
    'name' => 'Invoice',

    'order' => [
        'model' => env('ORDER_MODEL', \Modules\Order\Models\Order::class)
    ]
];
