<?php declare(strict_types=1);

use Yiisoft\Form\Widget\Form;
use Yiisoft\Html\Html;
use Mailery\Web\Widget\FlashMessage;
use Mailery\Brand\Widget\SettingsContent;

/** @var Yiisoft\Yii\WebView $this */
/** @var Psr\Http\Message\ServerRequestInterface $request */
/** @var Mailery\Brand\Entity\Brand $brand */
/** @var Mailery\Brand\Form\BrandForm $form */
/** @var string $csrf */
?>

<?= SettingsContent::widget()->begin(); ?>

<div class="mb-5"></div>
<div class="row">
    <div class="col-6">
        <?= FlashMessage::widget(); ?>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <?= Form::widget()
            ->action($urlGenerator->generate('/brand/settings/basic'))
            ->options(
                [
                    'id' => 'form-brand',
                    'csrf' => $csrf,
                    'enctype' => 'multipart/form-data',
                ]
            )
            ->begin(); ?>

        <?= $field->config($form, 'name'); ?>
        <?= $field->config($form, 'description')
            ->textArea([
                'class' => 'form-control textarea',
                'rows' => 2,
            ]); ?>
        <?= $field->config($form, 'channels')
            ->checkboxList($form->getChannelListOptions()); ?>

        <?= Html::submitButton(
            'Save',
            [
                'class' => 'btn btn-primary float-right mt-2'
            ]
        ); ?>

        <?= Form::end(); ?>
    </div>
</div>

<?= SettingsContent::end() ?>
