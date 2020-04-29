<?php

namespace Mailery\Brand\Service;

use Mailery\Brand\Entity\Brand;

interface BrandLocatorInterface
{
    /**
     * @return Brand
     */
    public function getBrand(): Brand;

    /**
     * @return bool
     */
    public function hasBrand(): bool;
}