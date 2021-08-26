<?php

namespace Mailery\Brand\Widget;

use Yiisoft\Yii\Bootstrap5\Nav;
use Yiisoft\Widget\Widget;
use Mailery\Brand\Menu\SettingsMenu;
use Yiisoft\Router\CurrentRoute;

class SettingsMenuWidget extends Widget
{
    /**
     * @var CurrentRoute
     */
    private CurrentRoute $currentRoute;

    /**
     * @var SettingsMenu
     */
    private SettingsMenu $settingsMenu;

    /**
     * @param CurrentRoute $currentRoute
     * @param SettingsMenu $settingsMenu
     */
    public function __construct(
        CurrentRoute $currentRoute,
        SettingsMenu $settingsMenu
    ) {
        $this->currentRoute = $currentRoute;
        $this->settingsMenu = $settingsMenu;
    }

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
