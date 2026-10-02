<?php

return [
    'panel' => [
        'menu' => function ($kirby) {
            return panelMenu($kirby)
                ->site(['label' => 'Dashboard'])
                ->separator()
                ->page('Notes', 'notes', ['icon' => 'pen'])
                ->page('Photography', $kirby->page('photography'), ['icon' => 'image'])
                ->page('About', 'page://D1yCxHPlHzgzBJI5', ['icon' => 'users'])
                ->separator()
                ->createPage('new-note', 'New Note', 'notes', 'site', 'notes')
                ->separator()
                ->area('users')
                ->area('system')
                ->toArray();
        }
    ]
];
