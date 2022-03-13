<?php

use Yiisoft\Form\Widget\Form;

/** @var Yiisoft\Form\Widget\Field $field */
/** @var Yiisoft\Yii\WebView $this */
/** @var Psr\Http\Message\ServerRequestInterface $request */
/** @var Yiisoft\Form\FormModelInterface $form */
/** @var string $csrf */

$this->setTitle('New Brand');

?><div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
            <h1 class="h3">New brand</h1>
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
    <div class="col-6">
        <?= Form::widget()
            ->action($urlGenerator->generate('/brand/default/create'))
            ->csrf($csrf)
            ->id('brand-form')
            ->begin(); ?>

        <?= $field->text($form, 'name')
                ->autofocus(); ?>

        <?= $field->textArea($form, 'description', ['rows()' => [5]])
                ->class('form-control'); ?>

        <?= $field->select($form, 'channels', ['items()' => [$form->getChannelListOptions()], 'multiple()' => [true]]); ?>

        <?= $field->submitButton()
                ->class('btn btn-primary float-right mt-2')
                ->value('Create'); ?>

        <?= Form::end(); ?>
    </div>
</div>
