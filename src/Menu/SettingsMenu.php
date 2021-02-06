<?php

namespace Mailery\Brand\Menu;

use Mailery\Menu\MenuInterface;

class SettingsMenu implements MenuInterface
{
    /**
     * @var MenuInterface
     */
    private MenuInterface $menu;

    /**
     * @param MenuInterface $menu
     */
    public function __construct(MenuInterface $menu)
    {
        $this->menu = $menu;
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return array_map(
            fn ($item) => $item->toArray(),
            $this->menu->getItems()
        );
    }
}
