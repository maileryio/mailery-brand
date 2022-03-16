<?php declare(strict_types=1);

use Mailery\Brand\Widget\SettingsMenuWidget;

/** @var Yiisoft\Yii\WebView $this */
/** @var Psr\Http\Message\ServerRequestInterface $request */
/** @var Mailery\Brand\Entity\Brand $brand */
/** @var Yiisoft\Form\FormModelInterface $form */
/** @var Mailery\Brand\Menu\SettingsMenu $settingsMenu */
/** @var Yiisoft\Yii\View\Csrf $csrf */

$this->setTitle('Settings');

?><div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
            <h1 class="h3">Settings</h1>
            <div class="btn-toolbar float-right">
                <a class="btn btn-sm btn-outline-secondary mx-sm-1 mb-2" href="<?= $urlGenerator->generate('/brand/default/index'); ?>">
                    Back
                </a>
            </div>
        </div>
    </div>
</div>
<div class="mb-2"></div>
<div class="row">
    <div class="col">
        <?= SettingsMenuWidget::widget(); ?>
    </div>
</div>

<?= $content ?>
