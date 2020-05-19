<?php declare(strict_types=1);

use Mailery\Icon\Icon;
use Mailery\Widget\Form\FormRenderer;

/** @var Mailery\Web\View\WebView $this */
/** @var Psr\Http\Message\ServerRequestInterface $request */
/** @var Mailery\Brand\Entity\Brand $brand */
/** @var Mailery\Brand\Form\BrandForm $brandForm */
/** @var bool $submitted */
$this->setTitle('Edit Brand #' . $brand->getId());

?><div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3">
            <h1 class="h2">Edit brand #<?= $brand->getId(); ?></h1>
            <div class="btn-toolbar float-right">
                <a class="btn btn-sm btn-info mx-sm-1 mb-2" href="<?= $urlGenerator->generate('/dashboard/default/index', ['brandId' => $brand->getId()]); ?>">
                    <?= Icon::widget()->name('eye')->options(['class' => 'mr-1']); ?>
                    View
                </a>
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
        <?= (new FormRenderer($brandForm))($submitted); ?>
    </div>
</div>
