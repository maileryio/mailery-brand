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
/** @var Yiisoft\I18n\TranslatorInterface $translator */
/** @var Yiisoft\Router\UrlGeneratorInterface $urlGenerator */
/** @var Yiisoft\Data\Reader\DataReaderInterface $dataReader*/

$this->setTitle('My Brands');

?><div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="card mb-4 shadow-sm" style="height: 180px;">
            <div class="card-body d-table p-0 h-100">
                <a href="<?= $urlGenerator->generate('/brand/default/create') ?>" class="btn btn-outline-light stretched-link  d-table-cell align-middle w-100 text-secondary">
                    <?= Icon::widget()->name('plus-circle')->options(['class' => 'h1']); ?>
                    <br />
                    Add new brand
                </a>
            </div>
        </div>
    </div><?php
    foreach ($dataReader->read() as $brand) {
        /* @var $brand Brand */
        ?><div class="col-md-6 col-lg-4">
            <div class="card mb-4 shadow-sm" style="height: 180px;">
                <div class="card-body h-50 position-relative">
                    <h5 class="card-title d-flex">
                        <?php $title = $translator->translate('{totalCount, number} {totalCount, plural, one{subscriber} other{subscribers}}', ['totalCount' => $brand->getTotalSubscribers()]); ?>
                        <a href="<?= $urlGenerator->generate('/dashboard/default/index', ['brandId' => $brand->getId()]) ?>" title="<?= $title ?>" class="text-decoration-none text-truncate text-body stretched-link">
                            <?= $brand->getName() ?>
                        </a>
                        <span class="badge badge-primary ml-2"><?= $brand->getTotalSubscribers() ?></span>
                    </h5>
                    <p class="card-text text-muted text-truncate" title="<?= $brand->getDescription() . $brand->getDescription() . $brand->getDescription() ?>">
                        <?= $brand->getDescription() . $brand->getDescription() . $brand->getDescription() ?>
                    </p>
                </div>
                <div class="card-body h-50 bg-light border-top">
                    <ul class="list-unstyled">
                        <li>
                            <?= Icon::widget()->name('check-circle')->options(['class' => 'text-success']); ?> Email messaging
                        </li>
                        <li>
                            <?= Icon::widget()->name('check-circle')->options(['class' => 'text-success']); ?> Web push notifications
                        </li>
                    </ul>
                </div>
            </div>
        </div><?php
    }
?></div>

