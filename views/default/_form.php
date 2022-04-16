<?php declare(strict_types=1);

use Yiisoft\Form\Widget\Form;

/** @var \Mailery\Brand\Form\BrandForm $form */
/** @var Yiisoft\Form\Widget\Field $field */
/** @var Yiisoft\Yii\WebView $this */
/** @var Yiisoft\Yii\View\Csrf $csrf */

?>
<?= Form::widget()
        ->csrf($csrf)
        ->id('brand-form')
        ->begin(); ?>

<?= $field->text($form, 'name')->autofocus(); ?>

<ui-multiselect
    v-model="example5.value"
    v-bind="example5"
></ui-multiselect>

<?= $field->select($form, 'channels', ['items()' => [$form->getChannelListOptions()], 'multiple()' => [true]]); ?>

<?= $field->textArea($form, 'description', ['rows()' => [5]])
        ->class('form-control'); ?>

<?= $field->submitButton()
        ->class('btn btn-primary float-right mt-2')
        ->value('Add brand'); ?>

<?= Form::end(); ?>
