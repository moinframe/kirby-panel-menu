<?php

/**
 * Menu generated from listed pages, with conditional entries
 * (languages only on multilang, system only for admins).
 */
return [
    'panel' => [
        'menu' => function ($kirby) {
            $menu = panelMenu($kirby)
                ->site()
                ->separator();

            foreach ($kirby->site()->children()->listed() as $page) {
                $menu->page($page->title()->value(), $page, ['icon' => 'page']);
            }

            $menu->separator()
                ->area('users');

            if ($kirby->multilang()) {
                $menu->area('languages');
            }

            if ($kirby->user()?->isAdmin()) {
                $menu->area('system');
            }

            return $menu->toArray();
        }
    ]
];
