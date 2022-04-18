<?php

namespace Mailery\Brand\Menu;

use Mailery\Menu\MenuInterface;

class SettingsMenu implements MenuInterface
{

    /**
     * @param MenuInterface $menu
     */
    public function __construct(
        private MenuInterface $menu
    ) {}

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
