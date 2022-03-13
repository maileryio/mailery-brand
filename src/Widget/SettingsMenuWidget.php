<?php

namespace Mailery\Brand\Widget;

use Yiisoft\Yii\Bootstrap5\Nav;
use Yiisoft\Widget\Widget;
use Mailery\Brand\Menu\SettingsMenu;
use Yiisoft\Router\CurrentRoute;

class SettingsMenuWidget extends Widget
{
    /**
     * @param CurrentRoute $currentRoute
     * @param SettingsMenu $settingsMenu
     */
    public function __construct(
        private CurrentRoute $currentRoute,
        private SettingsMenu $settingsMenu
    ) {}

    /**
     * @return string
     */
    protected function run(): string
    {
        return Nav::widget()
            ->options([
                'class' => 'nav nav-pills',
            ])
            ->currentPath(
                $this->currentRoute->getUri()->getPath()
            )
            ->items($this->settingsMenu->getItems())
            ->render();
    }
}
