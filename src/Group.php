<?php

namespace Vdhicts\Dicms\Filter;

use Vdhicts\Dicms\Filter\Contracts\Arrayable;

class Group implements Arrayable
{
    const CONJUNCTION_AND = 0;
    const CONJUNCTION_OR = 1;

    /**
     * Holds the name of the group.
     * @var string
     */
    private $name;

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
     * @param string $name
     * @param array $fields
     * @param int $conjunction
     */
    public function __construct($name, array $fields = [], $conjunction = self::CONJUNCTION_AND)
    {
        $this->setName($name);
        $this->setFields($fields);
        $this->setConjunction($conjunction);
    }

    /**
     * Returns the name of the group.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Stores the name of the group.
     * @param string $name
     * @return Group
     */
    private function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Returns all fields or the fields with the provided option.
     * @param string|null $option
     * @return array
     */
    public function getFields($option = null)
    {
        if (is_null($option)) {
            return $this->fields;
        }

        return array_filter(
            $this->fields,
            function ($field) use ($option) {
                return $field->getOption() === $option;
            }
        );
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
            'name'        => $this->getName(),
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
