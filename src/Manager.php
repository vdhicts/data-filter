<?php

namespace Vdhicts\Dicms\Filter;

use stdClass;
use Vdhicts\Dicms\Filter\Codec\Codec;
use Vdhicts\Dicms\Filter\Contracts\Codec as CodecContract;

class Manager
{
    /**
     * Holds the codec which can encode and decode the filter.
     * @var Codec
     */
    private $codec;

    /**
     * Manager constructor.
     * @param CodecContract $coder
     */
    public function __construct(CodecContract $coder)
    {
        $this->codec = $coder;
    }

    /**
     * Encodes the filter.
     * @param Filter $filter
     * @return string
     */
    public function encode(Filter $filter)
    {
        return $this->codec->encode(gzencode($filter->toJson()), Codec::MODE_URL_SAFE);
    }

    /**
     * Rebuilds the filter field.
     * @param stdClass $field
     * @return Field
     */
    private function rebuildFilterField(stdClass $field)
    {
        return new Field($field->option, $field->value, $field->approval);
    }

    /**
     * Rebuilds the filter group.
     * @param stdClass $group
     * @return Group
     */
    private function rebuildFilterGroup(stdClass $group)
    {
        $filterFields = [];
        foreach ($group->fields as $field) {
            $filterFields[] = $this->rebuildFilterField($field);
        }

        return new Group($group->name, $filterFields, $group->conjunction);
    }

    /**
     * Rebuilds the filter.
     * @param stdClass $filterData
     * @return Filter
     */
    private function rebuildFilter(stdClass $filterData)
    {
        $filter = new Filter();
        foreach ($filterData->groups as $group) {
            $filter->addGroup($this->rebuildFilterGroup($group));
        }

        return $filter;
    }

    /**
     * Decodes the filter.
     * @param string $filterString
     * @return Filter
     */
    public function decode($filterString)
    {
        $filterData = json_decode(gzdecode($this->codec->decode($filterString, Codec::MODE_URL_SAFE)));

        return $this->rebuildFilter($filterData);
    }
}
