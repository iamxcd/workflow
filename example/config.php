<?php

$order = [
    'marking_property' => 'status',
    'places' => [
        'created' => [
            'label' => '已创建'
        ],
        'paid' => [
            'label' => '已支付'
        ],
        'completed' => [
            'label' => '已完成'
        ],
        'refunded' => [
            'label' => '已退款'
        ],
    ],
    'transitions' => [
        'to_pay' => [
            'from' => 'created',
            'to' => 'paid',
            'meta' => [
                'label' => '付款'
            ]
        ],
        'to_complete' => [
            'from' => 'paid',
            'to' => 'completed',
            'meta' => [
                'label' => '完成'
            ]
        ],
        'to_refund' => [
            'from' => 'paid',
            'to' => 'refunded',
            'meta' => [
                'label' => '退款'
            ]
        ],
    ],
];

return $order;
