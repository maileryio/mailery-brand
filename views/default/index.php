<?php

use Mailery\Widget\Dataview\GridView;
use Mailery\Widget\Dataview\Columns\ActionColumn;
use Mailery\Widget\Dataview\Columns\DataColumn;
use Mailery\Widget\Dataview\Columns\SerialColumn;
use Mailery\Widget\Dataview\GridView\LinkPager;
use Mailery\Widget\Link\Link;
use Mailery\Brand\Entity\Brand;
use Mailery\Icon\Icon;
use Yiisoft\Html\Html;

/** @var Mailery\Web\View\WebView $this */
/** @var Yiisoft\Aliases\Aliases $aliases */
/** @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator */
/** @var Yiisoft\Data\Reader\DataReaderInterface $dataReader*/
/** @var Yiisoft\Data\Paginator\PaginatorInterface $paginator */

$this->setTitle('All Brands');

?><div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                <h1 class="h2">All Brands</h1>
                <div class="btn-toolbar float-right">
                    <form class="form-inline float-left">
                        <div class="input-group mx-sm-1 mb-2">
                            <input type="text" class="form-control form-control-sm" placeholder="Search">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-outline-secondary" type="button">
                                    <?= Icon::widget()->name('search'); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-sm btn-secondary dropdown-toggle mb-2">
                        <?= Icon::widget()->name('settings'); ?>
                    </button>
                    <a class="btn btn-sm btn-primary mx-sm-1 mb-2" href="<?= $urlGenerator->generate('/brand/default/create') ?>">
                        <?= Icon::widget()->name('plus')->options(['class' => 'mr-1']); ?>
                        New Brand
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-2"></div>
    <div class="row">
        <div class="col-12">
            <?= GridView::widget()
                ->paginator($paginator)
                ->options([
                    'class' => 'table-responsive',
                ])
                ->tableOptions([
                    'class' => 'table table-hover',
                ])
                ->emptyText('No data')
                ->emptyTextOptions([
                    'class' => 'text-center text-muted mt-4 mb-4',
                ])
                ->columns([
                    (new SerialColumn())
                        ->header('#')
                        ->paginator($paginator),
                    (new DataColumn())
                        ->header('Brand name')
                        ->content(function (Brand $data, int $index) {
                            return $data->getName();
                        }),
                    (new ActionColumn())
                        ->header('Actions')
                        ->view(function (Brand $data, int $index) use($urlGenerator) {
                            return Html::a(
                                Icon::widget()->name('eye'),
                                $urlGenerator->generate('/brand/default/view', ['id' => $data->getId()]),
                                [
                                    'class' => 'text-decoration-none mr-3',
                                ]
                            );
                        })
                        ->update(function (Brand $data, int $index) use($urlGenerator) {
                            return Html::a(
                                Icon::widget()->name('pencil'),
                                $urlGenerator->generate('/brand/default/edit', ['id' => $data->getId()]),
                                [
                                    'class' => 'text-decoration-none mr-3',
                                ]
                            );
                        })
                        ->delete(function (Brand $data, int $index) use($urlGenerator) {
                            return Link::widget()
                                ->label(Icon::widget()->name('delete')->options(['class' => 'mr-1']))
                                ->method('delete')
                                ->href($urlGenerator->generate('/brand/default/delete', ['id' => $data->getId()]))
                                ->confirm('Are you sure?')
                                ->options([
                                    'class' => 'text-decoration-none text-danger',
                                ]);
                        }),
                ]);
            ?>
        </div>
    </div><?php
    if ($paginator->getTotalCount() > 0) {
        ?><div class="mb-4"></div>
        <div class="row">
            <div class="col-6">
                <?= GridView\OffsetSummary::widget()
                    ->paginator($paginator);
                ?>
            </div>
            <div class="col-6">
                <?= LinkPager::widget()
                    ->paginator($paginator)
                    ->options([
                        'class' => 'float-right'
                    ])
                    ->prevPageLabel('Previous')
                    ->nextPageLabel('Next')
                    ->urlGenerator(function (int $page) use($urlGenerator) {
                        $url = $urlGenerator->generate('/brand/default/index');
                        if ($page > 1) {
                            $url = $url . '?page=' . $page;
                        }

                        return $url;
                    });
                ?>
            </div>
        </div><?php
    }
?>
