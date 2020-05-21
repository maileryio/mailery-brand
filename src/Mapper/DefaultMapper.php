<?php

namespace Mailery\Brand\Mapper;

use Mailery\Activity\Log\Mapper\LoggableMapper;
use Mailery\Cycle\Mapper\ChainItemList;

/**
 * @Cycle\Annotated\Annotation\Table(
 *      columns = {
 *          "created_at": @Cycle\Annotated\Annotation\Column(type = "datetime"),
 *          "updated_at": @Cycle\Annotated\Annotation\Column(type = "datetime")
 *      }
 * )
 */
class DefaultMapper extends LoggableMapper
{
    /**
     * {@inheritdoc}
     */
    protected function getModule(): string
    {
        return 'Brand';
    }

    /**
     * {@inheritdoc}
     */
    protected function getChainItemList(): ChainItemList
    {
        $itemList = parent::getChainItemList();

        return $itemList;
    }
}