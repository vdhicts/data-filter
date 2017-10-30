<?php

use PHPUnit\Framework\TestCase;
use Vdhicts\Dicms\Filter\OrderField;
use Vdhicts\Dicms\Filter\Exceptions;

class OrderFieldTest extends TestCase
{
    public function testOrderField()
    {
        $this->assertTrue(class_exists(OrderField::class));

        $field = 'test';
        $direction = 'asc';
        $orderField = new Orderfield($field, $direction);

        $this->assertInstanceOf(OrderField::class, $orderField);
        $this->assertSame($field, $orderField->getField());
        $this->assertSame(strtoupper($direction), $orderField->getDirection());
    }

    public function testToArray()
    {
        $field = 'test';
        $direction = 'asc';
        $orderField = new Orderfield($field, $direction);

        $orderFieldArray = $orderField->toArray();

        $this->assertTrue(is_array($orderFieldArray));
        $this->assertArrayHasKey('field', $orderFieldArray);
        $this->assertSame($field, $orderFieldArray['field']);
        $this->assertArrayHasKey('direction', $orderFieldArray);
        $this->assertSame(strtoupper($direction), $orderFieldArray['direction']);
    }

    public function testInvalidOrderFieldException()
    {
        $this->expectException(Exceptions\InvalidOrderField::class);

        new OrderField('');
    }

    public function testInvalidOrderDirectionException()
    {
        $this->expectException(Exceptions\InvalidOrderDirection::class);

        new OrderField('test', 'test');
    }
}
