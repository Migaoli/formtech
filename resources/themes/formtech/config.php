<?php

return [
    'name' => 'formtech',
    'layouts' => [
        'landing_page' => [
            'name' => 'Landing page',
            'description',
            'template' => 'layouts.landing_page',
            'grid' => [
                ['c1'],
                ['c2', 'c3', 'c4'],
                ['c5'],
            ],
        ],
        'single_page' => [
            'name' => 'Single Page',
            'description' => 'Page with only one column',
            'template' => 'layouts.single_page',
            'grid' => [
                ['c1']
            ]
        ]
    ]
];

