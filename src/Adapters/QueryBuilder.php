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
            default :
                return '=';
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
                /** @var Field $field */
                switch($group->getConjunction()) {
                    case Group::CONJUNCTION_AND:
                        $query->where(
                            $field->getOption(),
                            $adapter->getFilterFieldOperator($field->getApproval()),
                            $field->getValue()
                        );
                        break;
                    case Group::CONJUNCTION_OR:
                        $query->orWhere(
                            $field->getOption(),
                            $adapter->getFilterFieldOperator($field->getApproval()),
                            $field->getValue()
                        );
                        break;
                }
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
