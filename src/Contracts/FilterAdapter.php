<?php

namespace Vdhicts\Dicms\Filter\Contracts;

use Vdhicts\Dicms\Filter\Filter;
use Vdhicts\Dicms\Filter\Order;
use Vdhicts\Dicms\Pagination\Contracts\Paginator;

interface FilterAdapter
{
    /**
     * Returns the query builder with the filter applied.
     * @param mixed $builder
     * @param Filter $filter
     * @return mixed
     */
    public function getFilterQuery($builder, Filter $filter);

    /**
     * Returns the query builder with the order applied.
     * @param mixed $builder
     * @param Order $order
     * @return mixed
     */
    public function getOrderQuery($builder, Order $order);

    /**
     * Returns the query builder with the pagination applied.
     * @param mixed $builder
     * @param Paginator $pagination
     * @return mixed
     */
    public function getPaginationQuery($builder, Paginator $pagination);
}
