<?php

use PHPUnit\Framework\TestCase;
use Vdhicts\Dicms\Filter\Codec\Base64;
use Vdhicts\Dicms\Filter\Field;
use Vdhicts\Dicms\Filter\Filter;
use Vdhicts\Dicms\Filter\Group;
use Vdhicts\Dicms\Filter\Manager;
use Vdhicts\Dicms\Filter\Order;
use Vdhicts\Dicms\Filter\OrderField;
use Vdhicts\Dicms\Filter\Pagination;

class ManagerTest extends TestCase
{
    public function testManager()
    {
        $filterFields1 = [
            new Field('manufacturer', 1, Field::APPROVAL_ACCEPT),
            new Field('manufacturer', 2, Field::APPROVAL_ACCEPT)
        ];
        $filterGroup1 = new Group('group1', $filterFields1, Group::CONJUNCTION_OR);

        $filterFields2 = [
            new Field('type', 1, Field::APPROVAL_REJECT),
        ];
        $filterGroup2 = new Group('group2', $filterFields2);

        $filter = new Filter(
            [$filterGroup1, $filterGroup2],
            new Pagination(10, 1),
            new Order([
                new OrderField('test', 'desc')
            ])
        );

        $manager = new Manager(new Base64());
        $encodedFilter = $manager->encode($filter);

        $this->assertSame(
            'H4sIAAAAAAAAC4WOMQ7CMAxF7_LnDG3HrMAJGFEHq3WroDaJ0gQJRbk7ScMACMRmf_n5v4jZmWA3yEuEppUha9JCYDD6GvTgldGQrcCkeBnrqbE1xUo6TDT44Nhl5EZL4P2YrHUmr5BNEn-B7h3oC_Kq033qNN91_N3yD402f-0FjBtzsYx1qPj-qdC8-UyPyvGzBsfT-YDiA0uz0lTjWLZasKhV-Tw1KT0AJwgc-k0BAAA',
            $encodedFilter
        );

        $decodedFilter = $manager->decode($encodedFilter);

        $this->assertInstanceOf(Filter::class, $decodedFilter);
        $this->assertTrue(is_array($filter->getGroups()));
        $this->assertSame(2, count($filter->getGroups()));
    }
}
