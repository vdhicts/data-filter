<?php

namespace Vdhicts\Dicms\Filter\Contracts;

use Vdhicts\Dicms\Filter\Filter;

interface FilterAdapter
{
    /**
     * Returns the query builder with the filter applied.
     * @param mixed $builder
     * @param Filter $filter
     * @return mixed
     */
    public function getFilterQuery($builder, Filter $filter);
}
