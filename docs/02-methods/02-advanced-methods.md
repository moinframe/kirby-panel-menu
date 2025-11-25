---
title: Advanced Methods
description: custom, dialog, drawer, and createPage methods
---

## dialog()

Add a menu entry that opens a panel dialog.

```php
$menu->dialog('settings', 'Settings', 'my/custom/dialog', ['icon' => 'cog']);
```

**Parameters:** `$key`, `$label`, `$dialog` (dialog path), `$options`

## drawer()

Add a menu entry that opens a panel drawer.

```php
$menu->drawer('help', 'Help', 'my/custom/drawer', ['icon' => 'question']);
```

**Parameters:** `$key`, `$label`, `$drawer` (drawer path), `$options`

## createPage()

A shortcut to add a "create page" dialog entry. Instead of building the dialog URL yourself, just pass the parent page, view, and section:

```php
$menu->createPage('new-note', 'New Note', 'notes', 'site', 'notes');
```

This is equivalent to:

```php
$menu->dialog('new-note', 'New Note',
    'pages/create?parent=/pages/notes&view=site&section=notes',
    ['icon' => 'add']
);
```

**Parameters:** `$key`, `$label`, `$parentPage` (page path or UUID), `$view`, `$section`, `$options`


## custom()

Add a fully custom menu entry. You must provide `label`, `icon`, and one of `link`, `dialog`, or `drawer`.

```php
$menu->custom('analytics', [
    'label' => 'Analytics',
    'icon' => 'chart',
    'link' => 'pages/analytics'
]);
```
