<?php

return [
    'panel' => [
        'menu' => function ($kirby) {
            return panelMenu($kirby)
                ->site()
                ->separator()
                ->page('Home', 'home')
                ->separator()
                ->area('users')
                ->area('system')
                ->toArray();
        }
    ]
];
