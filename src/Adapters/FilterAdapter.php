<?php

namespace Vdhicts\Dicms\Filter\Adapters;

use Illuminate\Database\Query\Builder;
use Vdhicts\Dicms\Filter\Contracts;
use Vdhicts\Dicms\Filter\Filter;
use Vdhicts\Dicms\Filter\Field;
use Vdhicts\Dicms\Filter\Group;
use Vdhicts\Dicms\Filter\Order;
use Vdhicts\Dicms\Filter\OrderField;
use Vdhicts\Dicms\Pagination\Contracts\Paginator;

class FilterAdapter implements Contracts\FilterAdapter
{
    /**
     * Returns the filter field operator.
     * @param int $approval
     * @return string
     */
    private function getFilterFieldOperator($approval)
    {
        switch($approval) {
            case Field::APPROVAL_REJECT :
                return '!=';
            case Field::APPROVAL_START_OF_RANGE :
                return '>=';
            case Field::APPROVAL_END_OF_RANGE :
                return '<=';
            case Field::APPROVAL_LIKE :
                return 'LIKE';
            case Field::APPROVAL_ILIKE :
                return 'ILIKE';
            default :
                return '=';
        }
    }

    /**
     * Creates the filter field query.
     * @param Builder $query
     * @param Field $field
     * @param string $method
     * @return Builder
     */
    public function getFilterFieldQuery(Builder $query, Field $field, $method = 'and')
    {
        switch($field->getApproval()) {
            case Field::APPROVAL_NOT_IN :
                $query = $query->whereNotIn(
                    $field->getOption(),
                    $field->getValue(),
                    $method
                );
                break;
            case Field::APPROVAL_IN :
                $query = $query->whereIn(
                    $field->getOption(),
                    $field->getValue(),
                    $method
                );
                break;
            case Field::APPROVAL_LIKE :
            case Field::APPROVAL_ILIKE :
                $query = $query->where(
                    $field->getOption(),
                    $this->getFilterFieldOperator($field->getApproval()),
                    sprintf('%%%s%%', $field->getValue()),
                    $method
                );
                break;
            default :
                $query = $query->where(
                    $field->getOption(),
                    $this->getFilterFieldOperator($field->getApproval()),
                    $field->getValue(),
                    $method
                );
                break;
        }

        return $query;
    }

    /**
     * Returns the eloquent query builder with the group applied.
     * @param Builder $builder
     * @param Group $group
     * @return Builder
     */
    public function getFilterGroupQuery(Builder $builder, Group $group)
    {
        $adapter = $this;

        return $builder->where(function(Builder $query) use($adapter, $group) {
            foreach ($group->getFields() as $field) {
                $method = $group->getConjunction() == Group::CONJUNCTION_AND
                    ? 'and'
                    : 'or';

                $adapter->getFilterFieldQuery($query, $field, $method);
            }
        });
    }

    /**
     * Returns the query builder with the order applied.
     * @param mixed $builder
     * @param Order $order
     * @return mixed
     */
    public function getOrderQuery($builder, Order $order)
    {
        foreach ($order->get() as $orderField) {
            /** @var OrderField $orderField */
            $builder = $builder->orderBy($orderField->getField(), $orderField->getDirection());
        }

        return $builder;
    }

    /**
     * Returns the query builder with the pagination applied.
     * @param mixed $builder
     * @param Paginator $pagination
     * @return mixed
     */
    public function getPaginationQuery($builder, Paginator $pagination)
    {
        return $builder->limit($pagination->getLimit())
            ->offset($pagination->getOffset());
    }

    /**
     * Returns the eloquent query builder with the filter applied.
     * @param Builder $builder
     * @param Filter $filter
     * @return Builder
     */
    public function getFilterQuery($builder, Filter $filter)
    {
        $adapter = $this;

        // Apply the filter
        $queryBuilder = $builder->where(function(Builder $query) use($adapter, $filter) {
            foreach ($filter->getGroups() as $group) {
                $query = $adapter->getFilterGroupQuery($query, $group);
            }
        });

        // Apply the sort order
        $queryBuilder = $this->getOrderQuery($queryBuilder, $filter->getOrder());

        // Apply the pagination
        $queryBuilder = $this->getPaginationQuery($queryBuilder, $filter->getPagination());

        return $queryBuilder;
    }
}
