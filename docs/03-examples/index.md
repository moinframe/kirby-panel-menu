---
title: Examples
description: Real-world examples for common use cases
---

## Typical Setup

A typical setup with multiple pages and a quick-create button:

```php
return [
    'panel' => [
        'menu' => function ($kirby) {
            $menu = panelMenu($kirby);

            $menu->site([
                'label' => 'Dashboard'
            ]);

            $menu->separator();

            $menu->page('Notes', 'notes', [
                'icon' => 'pen'
            ]);

            $menu->page('Projects', 'projects', [
                'icon' => 'briefcase'
            ]);

            $menu->separator();

            $menu->createPage('new-note', 'New Note', 'notes', 'site', 'notes');

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
