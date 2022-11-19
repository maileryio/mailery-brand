<?php declare(strict_types=1);

use Mailery\Widget\Select\Select;
use Mailery\Web\Vue\Directive;
use Yiisoft\Form\Field;
use Yiisoft\Html\Tag\Form;

/** @var Mailery\Brand\Form\BrandForm $form */
/** @var Yiisoft\Yii\WebView $this */
/** @var Yiisoft\Yii\View\Csrf $csrf */

?>
<?= Form::tag()
        ->csrf($csrf)
        ->id('brand-form')
        ->post()
        ->open(); ?>

<?= Field::text($form, 'name')->autofocus(); ?>

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

<?= Directive::pre(Field::textarea($form, 'description', ['rows()' => [5]])); ?>

<?= Field::submitButton()
        ->content('Add brand'); ?>

<?= Form::tag()->close(); ?>
