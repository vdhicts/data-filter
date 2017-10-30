<?php

namespace Vdhicts\Dicms\Filter;

class Pagination
{
    const NO_LIMIT = -1;

    /**
     * Holds the limit.
     * @var int
     */
    private $limit = self::NO_LIMIT;

    /**
     * Holds the offset.
     * @var int
     */
    private $offset = 0;

    /**
     * Pagination constructor.
     * @param int $limit
     * @param int $offset
     */
    public function __construct($limit = self::NO_LIMIT, $offset = 0)
    {
        $this->setLimit($limit);
        $this->setOffset($offset);
    }

    /**
     * Returns the limit.
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Returns if a limit is provided.
     * @return bool
     */
    public function hasLimit()
    {
        return $this->getLimit() !== self::NO_LIMIT;
    }

    /**
     * Stores the limit.
     * @param int $limit
     * @return Pagination
     */
    public function setLimit($limit = self::NO_LIMIT)
    {
        if (! is_int($limit)) {
            $limit = self::NO_LIMIT;
        }

        $this->limit = $limit;

        return $this;
    }

    /**
     * Returns the offset.
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * Stores the offset.
     * @param int $offset
     * @return Pagination
     */
    public function setOffset($offset = 0)
    {
        if (! is_int($offset)) {
            $offset = 0;
        }

        $this->offset = $offset;

        return $this;
    }

    /**
     * Returns the array presentation of the OrderField.
     * @return array
     */
    public function toArray()
    {
        return [
            'offset' => $this->getOffset(),
            'limit'  => $this->getLimit(),
        ];
    }
}
