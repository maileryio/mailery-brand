<?php declare(strict_types=1);

use Mailery\Web\Widget\FlashMessage;
use Mailery\Widget\Select\Select;
use Yiisoft\Form\Widget\Form;
use Yiisoft\Yii\Widgets\ContentDecorator;

/** @var Yiisoft\Form\Widget\Field $field */
/** @var Yiisoft\Yii\WebView $this */
/** @var Yiisoft\Form\FormModelInterface $form */
/** @var Yiisoft\Yii\View\Csrf $csrf */
?>

<?= ContentDecorator::widget()
    ->viewFile('@vendor/maileryio/mailery-brand/views/settings/_layout.php')
    ->begin(); ?>

<div class="mb-2"></div>
<div class="row">
    <div class="col-12">
        <?= FlashMessage::widget(); ?>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?= Form::widget()
                ->action($url->generate('/brand/settings/basic'))
                ->csrf($csrf)
                ->id('brand-form')
                ->begin(); ?>

        <h6 class="font-weight-bold">General Information</h6>
        <div class="mb-3"></div>

        <?= $field->text($form, 'name')->autofocus(); ?>

        <?= $field->textArea($form, 'description', ['rows()' => [5]])
                ->class('form-control'); ?>

        <div class="mb-4"></div>
        <h6 class="font-weight-bold">Sending Setup</h6>
        <div class="mb-3"></div>

        <?= $field->select(
                $form,
                'channels',
                [
                    'class' => Select::class,
                    'items()' => [$form->getChannelListOptions()],
                    'multiple()' => [true],
                    'taggable()' => [true],
                    'deselectFromDropdown()' => [true],
                ]
            ); ?>

        <?= $field->submitButton()
                ->class('btn btn-primary float-right mt-2')
                ->value('Save changes'); ?>

        <?= Form::end(); ?>
    </div>
</div>

<?= ContentDecorator::end() ?>
