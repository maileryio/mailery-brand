<?php

namespace Mailery\Brand\Widget;

use Yiisoft\Yii\Bootstrap4\Nav;
use Yiisoft\Widget\Widget;
use Mailery\Brand\Menu\SettingsMenu;
use Yiisoft\Router\UrlMatcherInterface;

class SettingsMenuWidget extends Widget
{
    /**
     * @var UrlMatcherInterface
     */
    private UrlMatcherInterface $urlMatcher;

    /**
     * @var SettingsMenu
     */
    private SettingsMenu $settingsMenu;

    /**
     * @param UrlMatcherInterface $urlMatcher
     * @param SettingsMenu $settingsMenu
     */
    public function __construct(
        UrlMatcherInterface $urlMatcher,
        SettingsMenu $settingsMenu
    ) {
        $this->urlMatcher = $urlMatcher;
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
                'encode' => false,
            ])
            ->currentPath(
                $this->urlMatcher->getCurrentUri()->getPath()
            )
            ->items(array_map(
                function (array $item) {
                    return array_merge(
                        $item,
                        [
                            'options' => [
                                'encode' => false,
                            ],
                        ]
                    );
                },
                $this->settingsMenu->getItems()
            ));
    }
}
