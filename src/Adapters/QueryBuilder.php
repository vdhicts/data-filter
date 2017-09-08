<?php

namespace Vdhicts\Dicms\Filter\Adapters;

use Illuminate\Database\Query\Builder;
use Vdhicts\Dicms\Filter\Contracts\FilterAdapter;
use Vdhicts\Dicms\Filter\Filter;
use Vdhicts\Dicms\Filter\Field;
use Vdhicts\Dicms\Filter\Group;

class QueryBuilder implements FilterAdapter
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
                $query->whereNotIn(
                    $field->getOption(),
                    $field->getValue(),
                    $method
                );
                break;
            case Field::APPROVAL_IN :
                $query->whereIn(
                    $field->getOption(),
                    $field->getValue(),
                    $method
                );
                break;
            case Field::APPROVAL_LIKE :
            case Field::APPROVAL_ILIKE :
                $query->where(
                    $field->getOption(),
                    $this->getFilterFieldOperator($field->getApproval()),
                    sprintf('%%%s%%', $field->getValue()),
                    $method
                );
                break;
            default :
                $query->where(
                    $field->getOption(),
                    $this->getFilterFieldOperator($field->getApproval()),
                    $field->getValue(),
                    $method
                );
                break;
        }
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
     * Returns the eloquent query builder with the filter applied.
     * @param Builder $builder
     * @param Filter $filter
     * @return Builder
     */
    public function getFilterQuery($builder, Filter $filter)
    {
        $adapter = $this;

        return $builder->where(function(Builder $query) use($adapter, $filter) {
            foreach ($filter->getGroups() as $group) {
                $query = $adapter->getFilterGroupQuery($query, $group);
            }
        });
    }
}
