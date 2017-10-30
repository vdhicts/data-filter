<?php

namespace Vdhicts\Dicms\Filter\Contracts;

use Vdhicts\Dicms\Filter\Pagination;

interface PaginationAdapter
{
    /**
     * Returns the query builder with the pagination applied.
     * @param mixed $builder
     * @param Pagination $pagination
     * @return mixed
     */
    public function getPaginationQuery($builder, Pagination $pagination);
}
