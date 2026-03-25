# Kirby Panel Menu

Kirby Panel Menu is a plugin that adds a fluent, chainable PHP class for managing Kirby CMS panel menu entries with support for pages, sites, UUIDs, dialogs, drawers, and active state management.

## Installation

Via Composer:

```bash
composer require moinframe/kirby-panel-menu
```

As git submodule:

```bash
git submodule add https://github.com/moinframe/kirby-panel-menu.git site/plugins/panel-menu
```

Or download and place in `site/plugins/panel-menu/`.

## Quick Start

```php
return [
    'panel' => [
        'menu' => function ($kirby) {
            return panelMenu($kirby)
                ->site()
                ->separator()
                ->page('Blog', 'blog', ['icon' => 'book'])
                ->page('Projects', 'projects', ['icon' => 'briefcase'])
                ->separator()
                ->area('users')
                ->area('system')
                ->toArray();
        }
    ]
];
```

## Documentation

Full documentation is available at [moinfra.me/docs](https://moinfra.me/docs/moinframe-panel-menu).

## Requirements

- Kirby CMS 3.6+
- PHP 8.0+

## License

MIT
