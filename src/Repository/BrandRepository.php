<?php

declare(strict_types=1);

/**
 * Brand module for Mailery Platform
 * @link      https://github.com/maileryio/mailery-brand
 * @package   Mailery\Brand
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2020, Mailery (https://mailery.io/)
 */

namespace Mailery\Brand\Repository;

use Cycle\ORM\Select\QueryBuilder;
use Cycle\ORM\Select\Repository;
use Mailery\Brand\Entity\Brand;
use Yiisoft\Data\Reader\DataReaderInterface;
use Yiisoft\Yii\Cycle\Data\Reader\EntityReader;

class BrandRepository extends Repository
{
    /**
     * @param array $scope
     * @param array $orderBy
     * @return DataReaderInterface
     */
    public function getDataReader(array $scope = [], array $orderBy = []): DataReaderInterface
    {
        return new EntityReader($this->select()->where($scope)->orderBy($orderBy));
    }

    /**
     * @return self
     */
    public function withDeleted(): self
    {
        $repo = clone $this;
        $repo->select->constrain(null);

        return $repo;
    }

    /**
     * @param string $name
     * @param Brand|null $exclude
     * @return Brand|null
     */
    public function findByName(string $name, ?Brand $exclude = null): ?Brand
    {
        return $this
            ->select()
            ->where(function (QueryBuilder $select) use ($name, $exclude) {
                $select->where('name', $name);

                if ($exclude !== null) {
                    $select->where('id', '<>', $exclude->getId());
                }
            })
            ->fetchOne();
    }
}
