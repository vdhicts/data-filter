<?php

namespace Vdhicts\Dicms\Filter\Contracts;

use Vdhicts\Dicms\Filter\Order;

interface OrderAdapter
{
    /**
     * Returns the query builder with the order applied.
     * @param mixed $builder
     * @param Order $order
     * @return mixed
     */
    public function getOrderQuery($builder, Order $order);
}
