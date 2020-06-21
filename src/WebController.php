<?php

declare(strict_types=1);

namespace Mailery\Brand;

use Mailery\Common\Web\Controller;
use Psr\Http\Message\ResponseFactoryInterface;
use Yiisoft\Aliases\Aliases;
use Yiisoft\View\WebView;
use Mailery\Brand\Service\BrandLocator;
use Cycle\ORM\ORMInterface;
use Yiisoft\Assets\AssetManager;
use Mailery\Web\Assets\AppAssetBundle;
use Mailery\Brand\Assets\BrandAssetBundle;

abstract class WebController extends Controller
{

    /**
     * @inheritdoc
     */
    public function __construct(
        AssetManager $assetManager,
        BrandLocator $brandLocator,
        ResponseFactoryInterface $responseFactory,
        Aliases $aliases,
        WebView $view,
        ORMInterface $orm
    ) {
        $bundle = $assetManager->getBundle(AppAssetBundle::class);
        $bundle->depends[] = BrandAssetBundle::class;

        parent::__construct($brandLocator, $responseFactory, $aliases, $view, $orm);
    }

}
