<?php

declare(strict_types=1);

namespace Mailery\Brand\ViewInjection;

use Mailery\Brand\BrandLocatorInterface;
use Yiisoft\Yii\View\CommonParametersInjectionInterface;

class BrandLocatorViewInjection implements CommonParametersInjectionInterface
{
    /**
     * @param BrandLocatorInterface $brandLocator
     */
    public function __construct(
        private BrandLocatorInterface $brandLocator
    ) {}

    /**
     * @return array
     */
    public function getCommonParameters(): array
    {
        return [
            'brandLocator' => $this->brandLocator,
        ];
    }
}
