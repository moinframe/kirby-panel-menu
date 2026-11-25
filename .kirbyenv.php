<?php

return [
    'slug' => 'panel-menu',
    'variants' => [
        'k5'    => ['kirby' => 5],
        'k5-ml' => ['kirby' => 5, 'languages' => true],
        'k6'    => ['kirby' => 6],
        'k6-ml' => ['kirby' => 6, 'languages' => true],
    ],
    'languages' => [
        ['code' => 'en', 'name' => 'English', 'locale' => 'en_US'],
        ['code' => 'de', 'name' => 'Deutsch', 'locale' => 'de_DE'],
    ]
];
