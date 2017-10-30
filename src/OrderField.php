<?php

namespace Vdhicts\Dicms\Filter;

use Vdhicts\Dicms\Filter\Exceptions;

class OrderField
{
    const DEFAULT_DIRECTION = 'ASC';
    const SUPPORTED_DIRECTIONS = ['ASC', 'DESC'];

    /**
     * Holds the field.
     * @var string
     */
    private $field;

    /**
     * Holds the direction.
     * @var string
     */
    private $direction = self::DEFAULT_DIRECTION;

    /**
     * Order constructor.
     * @param string $field
     * @param string $direction
     */
    public function __construct($field, $direction = self::DEFAULT_DIRECTION)
    {
        $this->setField($field);
        $this->setDirection($direction);
    }

    /**
     * Returns the field.
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Stores the field.
     * @param string $field
     * @throws Exceptions\InvalidOrderField
     */
    private function setField($field)
    {
        if (! is_string($field) || strlen(trim($field)) === 0) {
            throw new Exceptions\InvalidOrderField($field);
        }

        $this->field = $field;
    }

    /**
     * Returns the direction.
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Stores the direction.
     * @param string $direction
     * @throws Exceptions\InvalidOrderDirection
     */
    private function setDirection($direction = self::DEFAULT_DIRECTION)
    {
        $direction = strtoupper($direction);

        if (! in_array($direction, self::SUPPORTED_DIRECTIONS)) {
            throw new Exceptions\InvalidOrderDirection($direction, self::SUPPORTED_DIRECTIONS);
        }

        $this->direction = $direction;
    }

    /**
     * Returns the array presentation of the OrderField.
     * @return array
     */
    public function toArray()
    {
        return [
            'field'     => $this->getField(),
            'direction' => $this->getDirection(),
        ];
    }
}