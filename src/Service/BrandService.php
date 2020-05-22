<?php

namespace Mailery\Brand\Service;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Transaction;
use Mailery\Brand\Entity\Brand;
use Mailery\Brand\ValueObject\BrandValueObject;

class BrandService
{
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
     * @param BrandValueObject $valueObject
     * @return Brand
     */
    public function create(BrandValueObject $valueObject): Brand
    {
        $brand = (new Brand())
            ->setName($valueObject->getName())
            ->setDescription($valueObject->getDescription())
        ;

        $tr = new Transaction($this->orm);
        $tr->persist($brand);
        $tr->run();

        return $brand;
    }

    /**
     * @param Brand $brand
     * @param BrandValueObject $valueObject
     * @return Brand
     */
    public function update(Brand $brand, BrandValueObject $valueObject): Brand
    {
        $brand = $brand
            ->setName($valueObject->getName())
            ->setDescription($valueObject->getDescription())
        ;

        $tr = new Transaction($this->orm);
        $tr->persist($brand);
        $tr->run();

        return $brand;
    }

    /**
     * @param Brand $brand
     * @return bool
     */
    public function delete(Brand $brand): bool
    {
        $tr = new Transaction($this->orm);
        $tr->delete($brand);
        $tr->run();

        return true;
    }
}