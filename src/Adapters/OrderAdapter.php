<?php

namespace Vdhicts\Dicms\Filter\Adapters;

use Vdhicts\Dicms\Filter\Contracts;
use Vdhicts\Dicms\Filter\Order;
use Vdhicts\Dicms\Filter\OrderField;

class OrderAdapter implements Contracts\OrderAdapter
{
    /**
     * Returns the query builder with the order applied.
     * @param mixed $builder
     * @param Order $order
     * @return mixed
     */
    public function getOrderQuery($builder, Order $order)
    {
        foreach ($order->get() as $orderField) {
            /** @var OrderField $orderField */
            $builder = $builder->orderBy($orderField->getField(), $orderField->getDirection());
        }

        return $builder;
    }
}
