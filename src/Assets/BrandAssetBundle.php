<?php

declare(strict_types=1);

namespace Mailery\Brand\Assets;

use Yiisoft\Assets\AssetBundle;
use Mailery\Web\Assets\VueAssetBundle;

class BrandAssetBundle extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public ?string $basePath = '@public/assets/@maileryio/mailery-brand-assets';

    /**
     * {@inheritdoc}
     */
    public ?string $baseUrl = '@web/@maileryio/mailery-brand-assets';

    /**
     * {@inheritdoc}
     */
    public ?string $sourcePath = '@npm/@maileryio/mailery-brand-assets/dist';

    /**
     * {@inheritdoc}
     */
    public array $js = [
        'main.umd.min.js',
    ];

    /**
     * {@inheritdoc}
     */
    public array $depends = [
        VueAssetBundle::class,
    ];
}
