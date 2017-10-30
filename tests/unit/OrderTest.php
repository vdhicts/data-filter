<?php

use PHPUnit\Framework\TestCase;
use Vdhicts\Dicms\Filter\Order;
use Vdhicts\Dicms\Filter\OrderField;

class OrderTest extends TestCase
{
    public function testOrderAddingFields()
    {
        $this->assertTrue(class_exists(Order::class));

        $field1 = 'test 1';
        $direction1 = 'asc';
        $orderField1 = new Orderfield($field1, $direction1);

        $field2 = 'test 2';
        $direction2 = 'desc';
        $orderField2 = new Orderfield($field2, $direction2);

        $order = new Order();

        $this->assertInstanceOf(Order::class, $order);
        $this->assertSame(0, count($order->get()));

        $order->add($orderField1);
        $this->assertSame(1, count($order->get()));

        $order->add($orderField2);
        $this->assertSame(2, count($order->get()));
    }

    public function testOrderInitializingWithFields()
    {
        $field2 = 'test 2';
        $direction2 = 'desc';
        $orderField2 = new Orderfield($field2, $direction2);

        $order = new Order([$orderField2]);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertSame(1, count($order->get()));
    }

    public function testOrderClearance()
    {
        $field2 = 'test 2';
        $direction2 = 'desc';
        $orderField2 = new Orderfield($field2, $direction2);

        $order = new Order([$orderField2]);
        $this->assertSame(1, count($order->get()));

        $order->clear();
        $this->assertSame(0, count($order->get()));
    }

    public function testOrderToArray()
    {
        $field2 = 'test 2';
        $direction2 = 'desc';
        $orderField2 = new Orderfield($field2, $direction2);

        $order = new Order([$orderField2]);
        $this->assertSame(1, count($order->get()));

        $orderArray = $order->toArray();
        $this->assertTrue(is_array($orderArray));
        $this->assertArrayHasKey('orders', $orderArray);
        $this->assertSame(1, count($orderArray['orders']));
    }

}
