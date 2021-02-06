<?php

namespace Mailery\Brand\Service;

use Cycle\ORM\ORMInterface;
use Mailery\Brand\Entity\Brand;
use Yiisoft\Validator\DataSetInterface;
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
     * @param DataSetInterface $data
     * @return Brand
     */
    public function create(DataSetInterface $data): Brand
    {
        $brand = (new Brand())
            ->setName($data->getAttributeValue('name'))
            ->setDescription($data->getAttributeValue('description'))
            ->setChannels($data->getAttributeValue('channels'))
        ;

        (new EntityWriter($this->orm))->write([$brand]);

        return $brand;
    }

    /**
     * @param Brand $brand
     * @param DataSetInterface $data
     * @return Brand
     */
    public function update(Brand $brand, DataSetInterface $data): Brand
    {
        $brand = $brand
            ->setName($data->getAttributeValue('name'))
            ->setDescription($data->getAttributeValue('description'))
            ->setChannels($data->getAttributeValue('channels'))
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