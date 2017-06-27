<?php

namespace Vdhicts\Dicms\Filter;

use Vdhicts\Dicms\Filter\Contracts\Arrayable;

class Group implements Arrayable
{
    const CONJUNCTION_AND = 0;
    const CONJUNCTION_OR = 1;

    /**
     * Holds if the conditions should all be matched.
     * @var int
     */
    private $conjunction = self::CONJUNCTION_AND;

    /**
     * Holds the fields.
     * @var array
     */
    private $fields = [];

    /**
     * Group constructor.
     * @param array $fields
     * @param int $conjunction
     */
    public function __construct(array $fields = [], $conjunction = self::CONJUNCTION_AND)
    {
        $this->setFields($fields);
        $this->setConjunction($conjunction);
    }

    /**
     * Returns if the conditions should all be matched.
     * @return int
     */
    public function getConjunction()
    {
        return $this->conjunction;
    }

    /**
     * Stores if the conditions should all be matched.
     * @param int $conjunction
     * @return Group
     */
    private function setConjunction($conjunction)
    {
        $this->conjunction = $conjunction;

        return $this;
    }

    /**
     * Returns the fields.
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Adds a field.
     * @param Field $field
     * @return Group
     */
    public function addField(Field $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * Stores the fields.
     * @param array $fields
     * @return Group
     */
    private function setFields(array $fields = [])
    {
        $this->fields = array_filter(
            $fields,
            function ($field) {
                return $field instanceof Field;
            }
        );

        return $this;
    }

    /**
     * Returns the array presentation of the Group.
     * @return array
     */
    public function toArray()
    {
        return [
            'conjunction' => $this->getConjunction(),
            'fields'      => array_map(
                function (Field $field) {
                    return $field->toArray();
                },
                $this->getFields()
            )
        ];
    }
}
