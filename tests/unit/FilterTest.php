<?php

use PHPUnit\Framework\TestCase;
use Vdhicts\Dicms\Filter\Codec\Base64;
use Vdhicts\Dicms\Filter\Exceptions\DuplicatedGroup;
use Vdhicts\Dicms\Filter\Field;
use Vdhicts\Dicms\Filter\Filter;
use Vdhicts\Dicms\Filter\Group;
use Vdhicts\Dicms\Filter\Manager;
use Vdhicts\Dicms\Filter\Order;
use Vdhicts\Dicms\Filter\OrderField;

class FilterTest extends TestCase
{
    public function testFilter()
    {
        $this->assertTrue(class_exists(Filter::class));

        $filterFields1 = [
            new Field('manufacturer', 1, Field::APPROVAL_ACCEPT),
            new Field('manufacturer', 2, Field::APPROVAL_ACCEPT)
        ];
        $filterGroup1 = new Group('group1', $filterFields1, Group::CONJUNCTION_OR);

        $filterFields2 = [
            new Field('type', 1, Field::APPROVAL_REJECT),
        ];
        $filterGroup2 = new Group('group2', $filterFields2);

        $filter = new Filter([
            $filterGroup1,
            $filterGroup2
        ]);

        $this->assertInstanceOf(Filter::class, $filter);
        $this->assertTrue(is_array($filter->getGroups()));
        $this->assertSame(2, count($filter->getGroups()));

        $filterFields3 = [
            new Field('price', 10, Field::APPROVAL_END_OF_RANGE),
        ];
        $filterGroup3 = new Group('group3', $filterFields3);

        $filter->addGroup($filterGroup3);

        $this->assertTrue(is_array($filter->getGroups()));
        $this->assertSame(3, count($filter->getGroups()));

        $filterArray = $filter->toArray();

        $this->assertTrue(is_array($filterArray));
        $this->assertArrayHasKey('groups', $filterArray);
        $this->assertTrue(is_array($filterArray['groups']));
        $this->assertSame(3, count($filterArray['groups']));

        $filterJson = $filter->toJson();

        $this->assertTrue(is_string($filterJson));

        $this->assertInstanceOf(Group::class, $filter->getGroup('group1'));
        $this->assertInstanceOf(Group::class, $filter->getGroup('group2'));
        $this->assertInstanceOf(Group::class, $filter->getGroup('group3'));

        $this->expectException(DuplicatedGroup::class);
        $filter->addGroup($filterGroup1);
    }
}
