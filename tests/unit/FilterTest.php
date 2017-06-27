<?php

use PHPUnit\Framework\TestCase;
use Vdhicts\Dicms\Filter\Codec\Base64;
use Vdhicts\Dicms\Filter\Field;
use Vdhicts\Dicms\Filter\Filter;
use Vdhicts\Dicms\Filter\Group;
use Vdhicts\Dicms\Filter\Manager;

class FilterTest extends TestCase
{
    public function testFilterField()
    {
        $this->assertTrue(class_exists(Field::class));

        $fieldKey = 'manufacturer';
        $fieldValue = 1;
        $fieldApproval = Field::APPROVAL_ACCEPT;
        $field = new Field($fieldKey, $fieldValue, $fieldApproval);

        $this->assertInstanceOf(Field::class, $field);
        $this->assertSame($fieldKey, $field->getOption());
        $this->assertSame($fieldValue, $field->getValue());
        $this->assertSame($fieldApproval, $field->getApproval());

        $fieldArray = $field->toArray();

        $this->assertTrue(is_array($fieldArray));
        $this->assertArrayHasKey('option', $fieldArray);
        $this->assertSame($fieldKey, $fieldArray['option']);
        $this->assertArrayHasKey('value', $fieldArray);
        $this->assertSame($fieldValue, $fieldArray['value']);
        $this->assertArrayHasKey('approval', $fieldArray);
        $this->assertSame($fieldApproval, $fieldArray['approval']);
    }

    /**
     * @depends testFilterField
     */
    public function testFilterGroup()
    {
        $this->assertTrue(class_exists(Group::class));

        $fields = [
            new Field('manufacturer', 1, Field::APPROVAL_ACCEPT),
            new Field('manufacturer', 2, Field::APPROVAL_ACCEPT)
        ];
        $group = new Group($fields, Group::CONJUNCTION_OR);

        $this->assertInstanceOf(Group::class, $group);
        $this->assertSame(Group::CONJUNCTION_OR, $group->getConjunction());
        $this->assertTrue(is_array($group->getFields()));
        $this->assertSameSize($fields, $group->getFields());

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

    /**
     * @depends testFilterGroup
     */
    public function testFilter()
    {
        $this->assertTrue(class_exists(Filter::class));

        $filterFields1 = [
            new Field('manufacturer', 1, Field::APPROVAL_ACCEPT),
            new Field('manufacturer', 2, Field::APPROVAL_ACCEPT)
        ];
        $filterGroup1 = new Group($filterFields1, Group::CONJUNCTION_OR);

        $filterFields2 = [
            new Field('type', 1, Field::APPROVAL_REJECT),
        ];
        $filterGroup2 = new Group($filterFields2);

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
        $filterGroup3 = new Group($filterFields3);

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
    }

    /**
     * @depends testFilter
     */
    public function testManager()
    {
        $filterFields1 = [
            new Field('manufacturer', 1, Field::APPROVAL_ACCEPT),
            new Field('manufacturer', 2, Field::APPROVAL_ACCEPT)
        ];
        $filterGroup1 = new Group($filterFields1, Group::CONJUNCTION_OR);

        $filterFields2 = [
            new Field('type', 1, Field::APPROVAL_REJECT),
        ];
        $filterGroup2 = new Group($filterFields2);

        $filter = new Filter([
            $filterGroup1,
            $filterGroup2
        ]);

        $manager = new Manager(new Base64());
        $encodedFilter = $manager->encode($filter);

        $this->assertSame('H4sIAAAAAAAAC4WNOwqAMBBE7zJ1CmOZq4hFiIkoml1iVhDx7v4qQbHc2XnzVrSJhCeYaoWj2Et0uaMIoxVC54fmfhHfKUYbJViXJfkEhdkO4q-yZU50nDDFpn6B8gnUJ_LQF-_6vLD_0Opjpd52qvpy4NEAAAA', $encodedFilter);

        $decodedFilter = $manager->decode($encodedFilter);

        $this->assertInstanceOf(Filter::class, $decodedFilter);
        $this->assertTrue(is_array($filter->getGroups()));
        $this->assertSame(2, count($filter->getGroups()));
    }
}
