<?php

use Yiisoft\Form\Widget\Form;
use Yiisoft\Html\Html;

/** @var Yiisoft\Yii\WebView $this */
/** @var Psr\Http\Message\ServerRequestInterface $request */
/** @var Mailery\Brand\Form\BrandForm $form */
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
            ->checkboxList($form->getChannelListOptions(), ['name' => $form->getFormName() . '[channels][]']); ?>

        <?= Html::submitButton(
            'Create',
            [
                'class' => 'btn btn-primary float-right mt-2',
            ]
        ); ?>

        <?= Form::end(); ?>
    </div>
</div>
