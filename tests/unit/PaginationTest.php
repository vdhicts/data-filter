<?php

use PHPUnit\Framework\TestCase;
use Vdhicts\Dicms\Filter\Pagination;

class PaginationTest extends TestCase
{
    public function testPaginationToArray()
    {
        $pagination = new Pagination(10, 1);
        $paginationArray = $pagination->toArray();

        $this->assertTrue(is_array($paginationArray));
        $this->assertArrayHasKey('limit', $paginationArray);
        $this->assertSame(10, $paginationArray['limit']);
        $this->assertArrayHasKey('page', $paginationArray);
        $this->assertSame(1, $paginationArray['page']);
    }
}
