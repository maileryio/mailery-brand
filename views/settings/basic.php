<?php declare(strict_types=1);

use Mailery\Web\Widget\FlashMessage;
use Mailery\Widget\Select\Select;
use Yiisoft\Html\Tag\Form;
use Yiisoft\Yii\Widgets\ContentDecorator;
use Yiisoft\Form\Field;

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
        <?= Form::tag()
                ->csrf($csrf)
                ->id('brand-form')
                ->post($url->generate('/brand/settings/basic'))
                ->open(); ?>

        <h6 class="font-weight-bold">General Information</h6>
        <div class="mb-3"></div>

        <?= Field::text($form, 'name')->autofocus(); ?>

        <?= Field::textarea($form, 'description', ['rows()' => [5]]); ?>

        <div class="mb-4"></div>
        <h6 class="font-weight-bold">Sending Setup</h6>
        <div class="mb-3"></div>

        <?= Field::input(
                Select::class,
                $form,
                'channels',
                [
                    'optionsData()' => [$form->getChannelListOptions()],
                    'multiple()' => [true],
                    'taggable()' => [true],
                    'deselectFromDropdown()' => [true],
                ]
            ); ?>

        <?= Field::submitButton()
                ->content('Save changes'); ?>

        <?= Form::tag()->close(); ?>
    </div>
</div>

<?= ContentDecorator::end() ?>
