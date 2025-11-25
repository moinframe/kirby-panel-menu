<?php

use \Moinframe\PanelMenu\PanelMenu;
use \Kirby\Toolkit\F;
use \Kirby\Cms\App as Kirby;

F::loadClasses([
    'Moinframe\\PanelMenu\\PanelMenu' => 'src/PanelMenu.php'
], __DIR__);

if (!function_exists('panelMenu')) {
    /**
     * @param mixed $kirby
     * @return PanelMenu
     */
    function panelMenu($kirby = null): PanelMenu
    {
        return PanelMenu::create($kirby);
    }
}

Kirby::plugin('moinframe/panel-menu', []);
