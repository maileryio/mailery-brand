<?php

namespace Mailery\Brand\Service;

use Cycle\ORM\EntityManagerInterface;
use Mailery\Brand\Entity\Brand;
use Mailery\Brand\ValueObject\BrandValueObject;
use Yiisoft\Yii\Cycle\Data\Writer\EntityWriter;

class BrandCrudService
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

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

        foreach ($valueObject->getChannels() as $channel) {
            $brand->getChannels()->add($channel);
        }

        (new EntityWriter($this->entityManager))->write([$brand]);

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

        foreach ($brand->getChannels() as $channel) {
            $brand->getChannels()->removeElement($channel);
        }

        foreach ($valueObject->getChannels() as $channel) {
            $brand->getChannels()->add($channel);
        }

        (new EntityWriter($this->entityManager))->write([$brand]);

        return $brand;
    }

    /**
     * @param Brand $brand
     * @return void
     */
    public function delete(Brand $brand): void
    {
        (new EntityWriter($this->entityManager))->delete([$brand]);
    }
}