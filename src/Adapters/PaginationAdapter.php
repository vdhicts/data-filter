<?php

namespace Vdhicts\Dicms\Filter;

use Vdhicts\Dicms\Filter\Contracts;

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