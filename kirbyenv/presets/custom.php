<?php

return [
    'panel' => [
        'menu' => function ($kirby) {
            $menu = panelMenu($kirby);

            $menu->site([
                'current' => $menu->currentExcluding('site', [
                    'pages/notes',
                    'pages/about',
                ]),
            ]);

            $menu->separator();

            $menu->custom('notes', [
                'label'   => 'Notes',
                'icon'    => 'pen',
                'link'    => 'pages/notes',
                'current' => $menu->currentCallback('pages/notes'),
            ]);

            $menu->custom('about', [
                'label'   => 'About',
                'icon'    => 'users',
                'link'    => 'pages/about',
                'current' => $menu->currentCallback(['pages/about']),
            ]);

            $menu->separator();

            $menu->dialog('new-page', 'New Page', 'pages/create?parent=site&view=site&section=pages', [
                'icon' => 'add',
            ]);

            $menu->dialog('new-user', 'New User', 'users/create', [
                'icon' => 'user',
            ]);

            $menu->custom('docs', [
                'label'  => 'Docs',
                'icon'   => 'book',
                'link'   => 'https://moinfra.me/docs/moinframe-panel-menu',
                'target' => '_blank',
            ]);

            $menu->separator();

            $menu->area('users', ['label' => 'Team']);
            $menu->area('system');

            return $menu->toArray();
        }
    ]
];
