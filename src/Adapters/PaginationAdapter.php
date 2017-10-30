<?php

namespace Vdhicts\Dicms\Filter\Adapters;

use Vdhicts\Dicms\Filter\Contracts;
use Vdhicts\Dicms\Filter\Pagination;

class PaginationAdapter implements Contracts\PaginationAdapter
{
    /**
     * Returns the query builder with the pagination applied.
     * @param mixed $builder
     * @param Pagination $pagination
     * @return mixed
     */
    public function getPaginationQuery($builder, Pagination $pagination)
    {
        return $builder->limit($pagination->getLimit())
            ->offset($pagination->getOffset());
    }
}