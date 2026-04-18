<?php

return [
    'status'=>  [
        'pending'      => [
            'class' => 'status-pending',
            'icon' => 'fas fa-clock',
        ],
        'in_progress'  => [
                'class' => 'status-active',
                'icon' => 'fas fa-spinner',
        ],
        'testing'      => [
            'class' => 'status-testing',
            'icon' => 'fas fa-vial',
        ],
        'completed'    => [
            'class' => 'status-completed',
            'icon' => 'fas fa-circle-check',
        ],
    ],
    'priority'  =>   [
        'low'    => [
            'class' => 'priority-low',
            'icon' => 'fas fa-arrow-down',
        ],
        'high'   => [
            'class' => 'priority-high',
            'icon' => 'fas fa-arrow-up',
        ],
    ],
];
