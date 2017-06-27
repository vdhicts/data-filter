<?php

namespace Vdhicts\Dicms\Filter;

use Vdhicts\Dicms\Filter\Contracts\Arrayable;
use Vdhicts\Dicms\Filter\Contracts\Jsonable;

class Filter implements Arrayable, Jsonable
{
    /**
     * Holds the groups for this filter.
     * @var array
     */
    private $groups = [];

    /**
     * Filter constructor.
     * @param array $groups
     */
    public function __construct(array $groups = [])
    {
        $this->setGroups($groups);
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @param Group $group
     * @return Filter
     */
    public function addGroup(Group $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * @param array $groups
     * @return Filter
     */
    public function setGroups(array $groups)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Returns the array presentation of the Filter.
     * @return array
     */
    public function toArray()
    {
        return [
            'groups' => array_map(
                function (Group $group) {
                    return $group->toArray();
                },
                $this->getGroups()
            )
        ];
    }

    /**
     * Convert the Filter to its JSON representation.
     * @param int $options
     * @param int $depth
     * @return string
     */
    public function toJson($options = 0, $depth = 512)
    {
        return json_encode($this->toArray(), $options, $depth);
    }
}
