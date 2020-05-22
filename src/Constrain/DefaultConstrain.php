<?php

namespace Mailery\Brand\Constrain;

use Cycle\ORM\Select\ConstrainInterface;
use Cycle\ORM\Select\QueryBuilder;

class DefaultConstrain implements ConstrainInterface
{
    /**
     * @inheritdoc
     */
    public function apply(QueryBuilder $query)
    {
        $query->where('deleted_at', '=', null);
    }
}
