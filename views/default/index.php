<?php declare(strict_types=1);

use Mailery\Activity\Log\Widget\ActivityLogLink;
use Mailery\Channel\Entity\Channel;
use Mailery\Channel\Model\ChannelTypeInterface;
use Mailery\Brand\Entity\Brand;
use Mailery\Icon\Icon;
use Mailery\Widget\Link\Link;
use Mailery\Web\Vue\Directive;

/** @var Yiisoft\Yii\WebView $this */
/** @var Mailery\Subscriber\Counter\SubscriberCounter $subscriberCounter /
/** @var Mailery\Channel\Model\ChannelTypeList $channelTypeList /
/** @var Yiisoft\Aliases\Aliases $aliases */
/** @var Yiisoft\Translator\TranslatorInterface $translator */
/** @var Yiisoft\Router\UrlGeneratorInterface $url */
/** @var Yiisoft\Yii\View\Csrf $csrf */

$this->setTitle('My Brands');

?><div class="row">
    <div class="col-md-6 col-lg-4">
        <div class="card mb-4 shadow-sm" style="height: 180px;">
            <div class="card-body d-table p-0 h-100">
                <a href="<?= $url->generate('/brand/default/create'); ?>" class="btn btn-outline-light stretched-link  d-table-cell align-middle w-100 text-secondary">
                    <?= Icon::widget()->name('plus-circle')->options(['class' => 'h1']); ?>
                    <br />
                    Add new brand
                </a>
            </div>
        </div>
    </div><?php
    foreach ($dataReader->read() as $brand) {
        /* @var $brand Brand */
        $subscriberCounter = $subscriberCounter->withBrand($brand);
        $settingsUrl = $url->generate('/brand/settings/basic', ['brandId' => $brand->getId()]);
        $dashboardUrl = $url->generate('/dashboard/default/index', ['brandId' => $brand->getId()]); ?><div class="col-md-6 col-lg-4">
            <ui-brand-card>
                <template v-slot:dropdown-button-content>
                    <?= Icon::widget()->name('chevron-down')->options(['class' => 'text-body h4']); ?>
                </template>
                <template v-slot:dropdown-button-items>
                    <b-dropdown-item href="<?= $dashboardUrl; ?>">Dashboard</b-dropdown-item>
                    <?= ActivityLogLink::widget()
                        ->entity($brand)
                        ->tag('b-dropdown-item')
                        ->label('Activity log'); ?>
                    <b-dropdown-item href="<?= $settingsUrl; ?>">Settings</b-dropdown-item>
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-text variant="danger" class="dropdown-item-custom-link">
                        <?= Link::widget()
                            ->csrf($csrf)
                            ->label('Delete brand')
                            ->method('delete')
                            ->href($url->generate('/brand/default/delete', ['id' => $brand->getId()]))
                            ->confirm('Are you sure?')
                            ->afterRequest(<<<JS
                                (res) => {
                                    res.redirected && res.url && (window.location.href = res.url);
                                }
                                JS
                            )
                            ->options([
                                'class' => 'btn btn-link text-decoration-none text-danger',
                            ])
                            ->encode(false); ?>
                    </b-dropdown-text>
                </template>

                <div class="card mb-4 shadow-sm" style="height: 180px;">
                    <div class="card-body h-50 position-relative">
                        <h5 class="card-title d-flex">
                            <?php $title = $translator->translate('{totalCount, number} {totalCount, plural, one{subscriber} other{subscribers}}', ['totalCount' => $subscriberCounter->getTotalCount()]); ?>
                            <a href="<?= $dashboardUrl; ?>" title="<?= $title; ?>" class="text-decoration-none text-truncate text-body stretched-link">
                                <?= Directive::pre($brand->getName()); ?>
                            </a>
                            <span class="badge badge-primary ml-2 mr-2"><?= $subscriberCounter->getTotalCount(); ?></span>
                        </h5>
                        <p class="card-text text-muted text-truncate">
                            <?= Directive::pre($brand->getDescription()); ?>
                        </p>
                    </div>
                    <div class="card-body h-50 bg-light border-top">
                        <ul class="list-unstyled">
                            <?php
                                $channelTypes = $brand->getChannels()
                                    ->map(fn (Channel $channel) => $channelTypeList->findByEntity($channel))
                                    ->toArray();

                                foreach ($channelTypeList as $channelType) {
                                    /** @var ChannelTypeInterface $channelType */
                                    $iconCssClass = 'text-secondary';

                                    if (in_array($channelType, $channelTypes)) {
                                        $iconCssClass = 'text-success';
                                    }

                                    $icon = Icon::widget()->name('check-circle')->options(['class' => $iconCssClass]);
                                    echo '<li>' . $icon . ' ' . $channelType->getLabel() . '</li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </ui-brand-card>
        </div><?php
    }
?></div>

