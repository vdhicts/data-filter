<?php

namespace Vdhicts\Dicms\Filter;

use Vdhicts\Dicms\Pagination\Contracts\Paginator;
use Vdhicts\Dicms\Pagination\Pagination as BasePagination;

class Pagination extends BasePagination implements Paginator
{
    /**
     * Returns the array presentation of the OrderField.
     * @return array
     */
    public function toArray()
    {
        return [
            'page'  => $this->getPage(),
            'limit' => $this->getLimit(),
        ];
    }
}
