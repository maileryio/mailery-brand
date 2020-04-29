<?php declare(strict_types=1);

use Mailery\Brand\Entity\Brand;
use Mailery\Icon\Icon;
use Mailery\Widget\Dataview\DetailView;
use Mailery\Widget\Link\Link;

/** @var Mailery\Web\View\WebView $this */
/** @var Psr\Http\Message\ServerRequestInterface $request */
/** @var \Mailery\Brand\Entity\Brand $brand */
/** @var bool $submitted */
$this->setTitle($brand->getName());

?><div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Brand #<?= $brand->getId(); ?></h1>
            <div class="btn-toolbar float-right">
                <?= Link::widget()
                    ->label((string) Icon::widget()->name('delete')->options(['class' => 'mr-1']) . ' Delete')
                    ->method('delete')
                    ->href($urlGenerator->generate('/brand/default/delete', ['id' => $brand->getId()]))
                    ->confirm('Are you sure?')
                    ->options([
                        'class' => 'btn btn-sm btn-danger mx-sm-1 mb-2',
                    ]);
                ?>
                <a class="btn btn-sm btn-secondary mx-sm-1 mb-2" href="<?= $urlGenerator->generate('/brand/default/edit', ['id' => $brand->getId()]); ?>">
                    <?= Icon::widget()->name('pencil')->options(['class' => 'mr-1']); ?>
                    Update
                </a>
                <div class="btn-toolbar float-right">
                    <a class="btn btn-sm btn-outline-secondary mx-sm-1 mb-2" href="<?= $urlGenerator->generate('/brand/default/index'); ?>">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="mb-2"></div>
<div class="row">
    <div class="col-12 grid-margin">
        <?= DetailView::widget()
            ->data($brand)
            ->options([
                'class' => 'table detail-view',
            ])
            ->emptyText('(not set)')
            ->emptyTextOptions([
                'class' => 'text-muted',
            ])
            ->attributes([
                [
                    'label' => 'Brand name',
                    'value' => function (Brand $data, $index) {
                        return $data->getName();
                    },
                ],
            ]);
        ?>
    </div>
</div>
