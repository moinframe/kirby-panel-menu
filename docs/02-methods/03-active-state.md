---
title: Active State
description: Control which menu items appear highlighted
---

By default, page entries are highlighted when viewing that page in the panel. But sometimes you need more control — for example, keeping the site entry from being highlighted when you're on a custom page entry.

## currentCallback()

Create a callback that highlights a menu item when the current panel path matches.

```php
$menu->custom('notes', [
    'icon' => 'pen',
    'label' => 'Notes',
    'link' => 'pages/notes',
    'current' => $menu->currentCallback('pages/notes')
]);
```

You can match multiple paths:

```php
$menu->currentCallback(['pages/notes', 'pages/blog'])
```

## currentExcluding()

Create a callback that highlights an item except when on specific paths. This is especially useful for the site entry:

```php
$menu->site([
    'current' => $menu->currentExcluding('site', [
        'pages/notes',
        'pages/blog'
    ])
]);
```

With this setup, the site entry stays highlighted on all panel pages except when viewing notes or blog pages.

> [!NOTE] When you use `page()` to add page entries, the site entry automatically gets a `currentExcluding` callback for those pages. You only need to set this up manually when using `custom()` entries.
