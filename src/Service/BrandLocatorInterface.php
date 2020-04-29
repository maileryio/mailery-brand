<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

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
