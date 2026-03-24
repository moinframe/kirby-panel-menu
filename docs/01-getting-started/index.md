---
title: Getting Started
description: Install and set up the Kirby Panel Menu plugin
---

## Installation

### Via Composer (Recommended)

```bash
composer require moinframe/kirby-panel-menu
```

### As Git Submodule

```bash
git submodule add https://github.com/moinframe/kirby-panel-menu.git site/plugins/panel-menu
```

### Manual Installation

Download or clone the repository and place it in your `site/plugins/` directory:

```
site/plugins/panel-menu/
```

## Basic Usage

The plugin provides a `panelMenu()` helper function and a `PanelMenu` class. Both give you a fluent, chainable API to build your panel menu.

Use it in your `site/config/config.php`:

```php
return [
    'panel' => [
        'menu' => function ($kirby) {
            return panelMenu($kirby)
                ->site()
                ->separator()
                ->area('users')
                ->toArray();
        }
    ]
];
```

You can also use the class directly:

```php
use Moinframe\PanelMenu\PanelMenu;

return [
    'panel' => [
        'menu' => function ($kirby) {
            return PanelMenu::create($kirby)
                ->site()
                ->separator()
                ->area('users')
                ->toArray();
        }
    ]
];
```

## Method Chaining

All methods return `$this`, so you can chain them together for clean, readable code:

```php
return panelMenu($kirby)
    ->site(['label' => 'Home'])
    ->separator()
    ->page('Blog', 'blog', ['icon' => 'book'])
    ->page('Projects', 'projects', ['icon' => 'briefcase'])
    ->separator()
    ->area('users')
    ->area('system')
    ->toArray();
```
