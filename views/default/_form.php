<?php declare(strict_types=1);

use Yiisoft\Form\Widget\Form;
use Mailery\Widget\Select\Select;

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

<?= $field->select($form, 'channels', ['items()' => [$form->getChannelListOptions()], 'multiple()' => [true]])
        ->template(strtr(
            "{label}\n{input}\n{hint}\n{error}",
            [
                '{input}' => Select::widget()
                    ->for($form, 'channels')
                    ->items($form->getChannelListOptions())
                    ->multiple(true)
                    ->taggable(true),
            ]
        )); ?>

<?= $field->textArea($form, 'description', ['rows()' => [5]])
        ->class('form-control'); ?>

<?= $field->submitButton()
        ->class('btn btn-primary float-right mt-2')
        ->value('Add brand'); ?>

<?= Form::end(); ?>
