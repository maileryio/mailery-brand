<?php

namespace Mailery\Brand\Mapper;

use Mailery\Activity\Log\Mapper\LoggableMapper;
use Mailery\Cycle\Mapper\ChainItemList;
use Mailery\Cycle\Mapper\ChainItem\SoftDeleted;
use Mailery\Brand\Module;

/**
 * @Cycle\Annotated\Annotation\Table(
 *      columns = {
 *          "created_at": @Cycle\Annotated\Annotation\Column(type = "datetime"),
 *          "updated_at": @Cycle\Annotated\Annotation\Column(type = "datetime"),
 *          "deleted_at": @Cycle\Annotated\Annotation\Column(type="datetime", nullable=true)
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
        return Module::NAME;
    }

    /**
     * {@inheritdoc}
     */
    protected function getChainItemList(): ChainItemList
    {
        $itemList = parent::getChainItemList();
        $itemList->add(
            (new SoftDeleted($this->orm))
                ->withDeletedAt('deleted_at')
        );

        return $itemList;
    }
}