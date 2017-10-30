<?php

namespace Vdhicts\Dicms\Filter;

class Order
{
    /**
     * Holds the orders.
     * @var array
     */
    private $orders = [];

    /**
     * Order constructor.
     * @param array $orders
     */
    public function __construct(array $orders = [])
    {
        foreach ($orders as $order) {
            $this->add($order);
        }
    }

    /**
     * Returns the orders.
     * @return array
     */
    public function get()
    {
        return $this->orders;
    }

    /**
     * Add an order to the collection.
     * @param OrderField $order
     * @return $this
     */
    public function add(OrderField $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Clears the orders.
     * @return $this
     */
    public function clear()
    {
        $this->orders = [];

        return $this;
    }

    /**
     * Returns the array presentation of the orders.
     * @return array
     */
    public function toArray()
    {
        return [
            'orders' => array_map(
                function (OrderField $orderField) {
                    return $orderField->toArray();
                },
                $this->get()
            )
        ];
    }
}
