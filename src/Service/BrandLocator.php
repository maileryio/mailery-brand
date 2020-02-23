<?php

namespace Mailery\Brand\Service;

use Mailery\Brand\Entity\Brand;
use Mailery\Brand\Exception\BrandRequiredException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Cycle\ORM\ORMInterface;

class BrandLocator
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
     * @var ORMInterface
     */
    private ORMInterface $orm;

    /**
     * @param ORMInterface $orm
     */
    public function __construct(ORMInterface $orm)
    {
        $this->orm = $orm;
    }

    /**
     * @param string $regexp
     * @return \self
     */
    public function withRegexp(string $regexp): self
    {
        $new = clone $this;
        $new->regexp = $regexp;
        return $new;
    }

    /**
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
     * @param Request $request
     * @return void
     */
    public function locate(Request $request): void
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        $brandId = null;
        $brandRepo = $this->orm->getRepository(Brand::class);

        if (preg_match($this->regexp, $path, $matches)) {
            $brandId = (int) $matches[1];
        }

        if ($brandId !== null) {
            $this->brand = $brandRepo->findByPk($brandId);
        }
    }

}