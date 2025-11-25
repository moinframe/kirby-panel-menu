---
title: Examples
description: Real-world examples for common use cases
---

## Content Management Setup

A typical setup with multiple content sections, quick-create buttons, and proper active state handling:

```php
return [
    'panel' => [
        'menu' => function ($kirby) {
            $menu = panelMenu($kirby);

            $menu->site([
                'label' => 'Dashboard',
                'current' => $menu->currentExcluding('site', [
                    'pages/notes',
                    'pages/blog',
                    'pages/projects'
                ])
            ]);

            $menu->separator();

            $menu->page('Notes', 'notes', [
                'icon' => 'pen',
                'current' => $menu->currentCallback('pages/notes')
            ]);

            $menu->page('Blog', 'blog', [
                'icon' => 'book',
                'current' => $menu->currentCallback('pages/blog')
            ]);

            $menu->page('Projects', 'projects', [
                'icon' => 'briefcase',
                'current' => $menu->currentCallback('pages/projects')
            ]);

            $menu->separator();

            $menu->createPage('new-note', 'New Note', 'notes', 'site', 'notes');
            $menu->createPage('new-post', 'New Post', 'blog', 'site', 'articles');

            $menu->separator();

            $menu->area('users');
            $menu->area('system');

            return $menu->toArray();
        }
    ]
];
```

## Conditional Menu Items

Show or hide entries based on page existence or user role:

```php
return [
    'panel' => [
        'menu' => function ($kirby) {
            $menu = panelMenu($kirby);

            $menu->site()
                ->separator()
                ->page('Blog', 'blog', ['icon' => 'book']);

            // Only show if the page exists
            if ($kirby->page('projects')) {
                $menu->page('Projects', 'projects', ['icon' => 'briefcase']);
            }

            $menu->separator()
                ->area('users');

            // Only show system to admins
            if ($kirby->user()?->isAdmin()) {
                $menu->area('system');
            }

            return $menu->toArray();
        }
    ]
];
```

## Dialogs and Drawers

Combine page links with custom dialogs and drawers:

```php
return [
    'panel' => [
        'menu' => function ($kirby) {
            return panelMenu($kirby)
                ->site()
                ->separator()
                ->page('Blog', 'blog')
                ->separator()
                ->dialog('new-article', 'New Article',
                    'pages/create?parent=/pages/blog&view=site&section=articles',
                    ['icon' => 'add']
                )
                ->dialog('import', 'Import Data',
                    'custom/import/dialog',
                    ['icon' => 'upload']
                )
                ->drawer('help', 'Help',
                    'my/custom/drawer',
                    ['icon' => 'question']
                )
                ->toArray();
        }
    ]
];
```
