<?php

use PHPUnit\Framework\TestCase;
use Vdhicts\Dicms\Filter\Pagination;

class PaginationTest extends TestCase
{
    public function testPaginationInitialization()
    {
        $this->assertTrue(class_exists(Pagination::class));

        $pagination = new Pagination();

        $this->assertSame(-1, $pagination->getLimit());
        $this->assertFalse($pagination->hasLimit());
        $this->assertSame(0, $pagination->getOffset());
    }

    public function testPaginationFallbackToDefaults()
    {
        $pagination = new Pagination('a', 'a');

        $this->assertSame(-1, $pagination->getLimit());
        $this->assertFalse($pagination->hasLimit());
        $this->assertSame(0, $pagination->getOffset());
    }

    public function testPaginationToArray()
    {
        $pagination = new Pagination(10, 20);
        $paginationArray = $pagination->toArray();

        $this->assertTrue(is_array($paginationArray));
        $this->assertArrayHasKey('limit', $paginationArray);
        $this->assertSame(10, $paginationArray['limit']);
        $this->assertArrayHasKey('offset', $paginationArray);
        $this->assertSame(20, $paginationArray['offset']);
    }
}
