<?php

use PHPUnit\Framework\TestCase;
use Vdhicts\Dicms\Filter\Field;
use Vdhicts\Dicms\Filter\Group;

class FilterGroupTest extends TestCase
{
    public function testFilterGroup()
    {
        $this->assertTrue(class_exists(Group::class));

        $fields = [
            new Field('manufacturer', 1, Field::APPROVAL_ACCEPT),
            new Field('manufacturer', 2, Field::APPROVAL_ACCEPT)
        ];
        $group = new Group('group1', $fields, Group::CONJUNCTION_OR);

        $this->assertInstanceOf(Group::class, $group);
        $this->assertSame(Group::CONJUNCTION_OR, $group->getConjunction());
        $this->assertTrue(is_array($group->getFields()));
        $this->assertSameSize($fields, $group->getFields());
        $this->assertSame('group1', $group->getName());
        $this->assertTrue(is_array($group->getFields('manufacturer')));
        $this->assertSameSize($fields, $group->getFields('manufacturer'));

        $filterField = new Field('manufacturer', 3, Field::APPROVAL_REJECT);

        $group->addField($filterField);

        $this->assertSame(Group::CONJUNCTION_OR, $group->getConjunction());
        $this->assertTrue(is_array($group->getFields()));
        $this->assertSame(3, count($group->getFields()));

        $groupArray = $group->toArray();

        $this->assertTrue(is_array($groupArray));
        $this->assertArrayHasKey('conjunction', $groupArray);
        $this->assertSame(Group::CONJUNCTION_OR, $groupArray['conjunction']);
        $this->assertArrayHasKey('fields', $groupArray);
        $this->assertTrue(is_array($groupArray['fields']));
        $this->assertSame(3, count($groupArray['fields']));
    }
}
