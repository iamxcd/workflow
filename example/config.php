<?php

$config = [
    'marking_property' => 'status',
    'places' => [
        'default' => [
            'label' => '填写(修改)表单'
        ],
        'bmdsh' => [
            'label' => '部门待审核'
        ],
        'bmsh' => [
            'label' => '部门已审核'
        ],
        'cwdsh' => [
            'label' => '财务待审核'
        ],
        'cwsh' => [
            'label' => '财务已审核'
        ],
        'lcwc' => [
            'label' => '流程已完成'
        ],
    ],
    'transitions' => [
        'xgbd' => [
            'from' => 'default',
            'to' => 'default',
            'meta' => [
                'label' => '修改表单'
            ]
        ],
        'tjbmsh' => [
            'from' => 'default',
            'to' => 'bmdsh',
            'meta' => [
                'label' => '提交审核'
            ]
        ],
        'bmshtg' => [
            'from' => 'bmdsh',
            'to' => 'bmsh',
            'meta' => [
                'label' => '部门审核通过'
            ]
        ],
        'bmshwtg' => [
            'from' => 'bmdsh',
            'to' => 'default',
            'meta' => [
                'label' => '部门审核未通过'
            ]
        ],
        'tjcwsh' => [
            'from' => 'bmsh',
            'to' => 'cwdsh',
            'meta' => [
                'label' => '提交审核'
            ]
        ],
        'cwshtg' => [
            'from' => 'cwdsh',
            'to' => 'cwsh',
            'meta' => [
                'label' => '财务审核通过'
            ]
        ],
        'cwshwtg' => [
            'from' => 'cwdsh',
            'to' => 'default',
            'meta' => [
                'label' => '财务审核未通过'
            ]
        ],
        'bxwc' => [
            'from' => 'cwsh',
            'to' => 'lcwc',
            'meta' => [
                'label' => '报销完成'
            ]
        ],
    ],
];

return $config;
