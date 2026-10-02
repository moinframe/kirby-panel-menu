<?php

return [
    'panel' => [
        'menu' => function ($kirby) {
            return panelMenu($kirby)
                ->site()
                ->separator()
                ->page('Photography', 'photography', ['icon' => 'image'])
                ->page('Sky', 'photography/sky', ['icon' => 'cloud'])
                ->page('Ocean', 'photography/ocean', ['icon' => 'cloud'])
                ->separator()
                ->page('Notes', 'notes', ['icon' => 'pen'])
                ->page('Across the Ocean', 'notes/across-the-ocean', ['icon' => 'text'])
                ->separator()
                ->area('users')
                ->area('system')
                ->toArray();
        }
    ]
];
