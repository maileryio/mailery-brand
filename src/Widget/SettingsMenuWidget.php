<?php

namespace Mailery\Brand\Widget;

use Yiisoft\Yii\Bootstrap5\Nav;
use Yiisoft\Widget\Widget;
use Mailery\Brand\Menu\SettingsMenu;
use Yiisoft\Router\CurrentRoute;

class SettingsMenuWidget extends Widget
{

    /**
     * @var array
     */
    private array $options = [];

    /**
     * @param CurrentRoute $currentRoute
     * @param SettingsMenu $settingsMenu
     */
    public function __construct(
        private CurrentRoute $currentRoute,
        private SettingsMenu $settingsMenu
    ) {}

    /**
     * @param array $value
     * @return self
     */
    public function options(array $value): self
    {
        $new = clone $this;
        $new->options = $value;

        return $new;
    }

    /**
     * @return string
     */
    protected function run(): string
    {
        return Nav::widget()
            ->options($this->options)
            ->currentPath(
                $this->currentRoute->getUri()->getPath()
            )
            ->items($this->settingsMenu->getItems())
            ->render();
    }

}
