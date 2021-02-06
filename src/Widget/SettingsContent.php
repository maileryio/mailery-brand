<?php

namespace Mailery\Brand\Widget;

use Yiisoft\Widget\Widget;
use Yiisoft\View\WebView;
use Yiisoft\Aliases\Aliases;
use Mailery\Brand\Menu\SettingsMenu;

class SettingsContent extends Widget
{
    /**
     * @var string|null
     */
    private ?string $viewFile = null;

    /**
     * @var Aliases
     */
    private Aliases $aliases;

    /**
     * @var WebView
     */
    private WebView $webView;

    /**
     * @var SettingsMenu
     */
    private SettingsMenu $settingsMenu;

    /**
     * @param Aliases $aliases
     * @param WebView $webView
     * @param SettingsMenu $settingsMenu
     */
    public function __construct(Aliases $aliases, WebView $webView, SettingsMenu $settingsMenu)
    {
        $this->aliases = $aliases;
        $this->webView = $webView;
        $this->settingsMenu = $settingsMenu;

        $this->viewFile('@vendor/maileryio/mailery-brand/views/settings/_layout.php');
    }

    /**
     * @return string|null
     */
    public function begin(): ?string
    {
        parent::begin();
        /** Starts recording a clip. */
        ob_start();
        PHP_VERSION_ID >= 80000 ? ob_implicit_flush(false) : ob_implicit_flush(0);
        return null;
    }

    /**
     * @return string
     */
    public function run(): string
    {
        return $this->webView->renderFile(
            $this->viewFile,
            [
                'content' => ob_get_clean(),
                'settingsMenu' => $this->settingsMenu,
            ]
        );
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function viewFile(?string $value): self
    {
        $this->viewFile = $this->aliases->get($value);

        return $this;
    }

}
