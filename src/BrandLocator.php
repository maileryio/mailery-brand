<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Brand;

use Mailery\Brand\Entity\Brand;
use Mailery\Brand\Exception\BrandRequiredException;
use Mailery\Brand\Repository\BrandRepository;
use Psr\Http\Message\ServerRequestInterface as Request;

class BrandLocator implements BrandLocatorInterface
{
    /**
     * @var string|null
     */
    private ?string $regexp = null;

    /**
     * @var Brand|null
     */
    private ?Brand $brand = null;

    /**
     * @param BrandRepository $brandRepo
     */
    public function __construct(
        private BrandRepository $brandRepo
    ) {}

    /**
     * @throws BrandRequiredException
     * @return Brand
     */
    public function getBrand(): Brand
    {
        if ($this->brand === null) {
            throw new BrandRequiredException();
        }

        return $this->brand;
    }

    /**
     * @param string $regexp
     * @return self
     */
    public function withRegexp(string $regexp): self
    {
        $new = clone $this;
        $new->regexp = $regexp;

        return $new;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function locate(Request $request): void
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        $brandId = null;
        if ($this->regexp !== null && preg_match($this->regexp, $path, $matches) && !empty($matches['brandId'])) {
            $brandId = (int) $matches['brandId'];
        }

        if ($brandId !== null) {
            $this->brand = $this->brandRepo->findByPk($brandId);
        }
    }

    /**
     * @return bool
     */
    public function hasBrand(): bool
    {
        return $this->brand !== null;
    }
}
