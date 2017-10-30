<?php

namespace Vdhicts\Dicms\Filter;

use Vdhicts\Dicms\Filter\Contracts;
use Vdhicts\Dicms\Filter\Exceptions;

class Filter implements Contracts\Arrayable, Contracts\Jsonable
{
    /**
     * Holds the groups for this filter.
     * @var array
     */
    private $groups = [];

    /**
     * Holds the pagination.
     * @var Pagination
     */
    private $pagination;

    /**
     * Holds the order.
     * @var Order
     */
    private $order;

    /**
     * Filter constructor.
     * @param array $groups
     * @param Pagination|null $pagination
     * @param Order|null $order
     */
    public function __construct(array $groups = [], Pagination $pagination = null, Order $order = null)
    {
        $this->setGroups($groups);
        $this->setPagination($pagination);
        $this->setOrder($order);
    }

    /**
     * Returns the group with the provided name.
     * @param string $name
     * @return null|Group
     */
    public function getGroup($name)
    {
        foreach ($this->groups as $group) {
            if ($group->getName() === $name) {
                return $group;
            }
        }

        return null;
    }

    /**
     * Returns all the groups in the filter.
     * @return array
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Adds a group.
     * @param Group $group
     * @return Filter
     * @throws Exceptions\DuplicatedGroup
     */
    public function addGroup(Group $group)
    {
        // Force a group name to be unique
        $currentGroup = $this->getGroup($group->getName());
        if ( ! is_null($currentGroup)) {
            throw new Exceptions\DuplicatedGroup();
        }

        $this->groups[] = $group;

        return $this;
    }

    /**
     * Stores the groups.
     * @param array $groups
     * @return Filter
     */
    public function setGroups(array $groups)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * Returns the pagination.
     * @return Pagination
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    /**
     * Stores the pagination.
     * @param Pagination $pagination
     */
    public function setPagination(Pagination $pagination = null)
    {
        if (is_null($pagination)) {
            $pagination = new Pagination();
        }

        $this->pagination = $pagination;
    }

    /**
     * Returns the order.
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Stores the order.
     * @param Order $order
     */
    public function setOrder(Order $order = null)
    {
        if (is_null($order)) {
            $order = new Order();
        }

        $this->order = $order;
    }

    /**
     * Returns the array presentation of the Filter.
     * @return array
     */
    public function toArray()
    {
        return [
            'groups'     => array_map(
                function (Group $group) {
                    return $group->toArray();
                },
                $this->getGroups()
            ),
            'order'      => $this->getOrder()->toArray(),
            'pagination' => $this->getPagination()->toArray()
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
