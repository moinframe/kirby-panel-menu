<?php

return [
    'panel' => [
        'menu' => function ($kirby) {
            return panelMenu($kirby)
                ->site()
                ->separator()
                ->page('Film', 'film', ['icon' => 'video'])
                ->page('Filmreihe', 'filmreihe', ['icon' => 'list-bullet'])
                ->separator()
                ->area('users')
                ->area('system')
                ->toArray();
        }
    ]
];
