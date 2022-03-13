<?php declare(strict_types=1);

use Mailery\Web\Widget\FlashMessage;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Yii\Widgets\ContentDecorator;

/** @var Yiisoft\Form\Widget\Field $field */
/** @var Yiisoft\Yii\WebView $this */
/** @var Yiisoft\Form\FormModelInterface $form */
/** @var string $csrf */
?>

<?= ContentDecorator::widget()
    ->viewFile('@vendor/maileryio/mailery-brand/views/settings/_layout.php')
    ->begin(); ?>

<div class="mb-5"></div>
<div class="row">
    <div class="col-12 col-xl-4">
        <?= FlashMessage::widget(); ?>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-4">
        <?= Form::widget()
                ->action($urlGenerator->generate('/brand/settings/basic'))
                ->csrf($csrf)
                ->id('brand-form')
                ->begin(); ?>

        <h3 class="h6">General Information</h3>
        <div class="mb-4"></div>

        <?= $field->text($form, 'name')
                ->autofocus(); ?>

        <?= $field->textArea($form, 'description', ['rows()' => [5]])
                ->class('form-control'); ?>

        <div class="mb-5"></div>
        <h3 class="h6">Sending Setup</h3>
        <div class="mb-4"></div>

        <?= $field->select($form, 'channels', ['items()' => [$form->getChannelListOptions()], 'multiple()' => [true]]); ?>

        <?= $field->submitButton()
                ->class('btn btn-primary float-right mt-2')
                ->value('Save'); ?>

        <?= Form::end(); ?>
    </div>
</div>

<?= ContentDecorator::end() ?>
