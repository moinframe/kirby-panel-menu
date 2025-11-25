---
title: Core Methods
description: site, page, area, and separator methods
---

## site()

Add the site entry to the menu. This is usually the first item.

```php
$menu->site();
```

You can customize the label and icon:

```php
$menu->site(['label' => 'Dashboard', 'icon' => 'home']);
```

## page()

Add a page link to the menu. Accepts a label, a page reference, and optional settings.

### Using a page path

```php
$menu->page('Notes', 'notes', ['icon' => 'pen']);
```

### Using a page object

```php
$notesPage = $kirby->page('notes');
$menu->page('Notes', $notesPage, ['icon' => 'pen']);
```

### Using a UUID

```php
$menu->page('Featured', 'page://hb38HvnQfm8HlQ6e', ['icon' => 'star']);
```

UUIDs are useful when page paths might change but the UUID stays stable.

**Available options:** `icon`, `target`, `title`, `current`

## area()

Add a built-in panel area like users, languages, or system.

```php
$menu->area('users');
$menu->area('languages');
$menu->area('system');
```

You can customize the label:

```php
$menu->area('users', ['label' => 'Team']);
```

## separator()

Add a visual divider between menu items.

```php
$menu->site()
    ->separator()
    ->page('Blog', 'blog')
    ->separator()
    ->area('users');
```
