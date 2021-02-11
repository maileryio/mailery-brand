<?php

namespace Mailery\Brand\Service;

use Cycle\ORM\ORMInterface;
use Mailery\Brand\Entity\Brand;
use Mailery\Brand\ValueObject\BrandValueObject;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

class BrandCrudService
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
            ->setChannels($valueObject->getChannels())
        ;

        (new EntityWriter($this->orm))->write([$brand]);

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
            ->setChannels($valueObject->getChannels())
        ;

        (new EntityWriter($this->orm))->write([$brand]);

        return $brand;
    }

    /**
     * @param Brand $brand
     * @return void
     */
    public function delete(Brand $brand): void
    {
        (new EntityWriter($this->orm))->delete([$brand]);
    }
}