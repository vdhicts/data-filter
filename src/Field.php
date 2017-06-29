<?php

namespace Vdhicts\Dicms\Filter;

use Vdhicts\Dicms\Filter\Contracts\Arrayable;

class Field implements Arrayable
{
    const APPROVAL_ACCEPT = 0;
    const APPROVAL_REJECT = 1;
    const APPROVAL_START_OF_RANGE = 2;
    const APPROVAL_END_OF_RANGE = 3;

    /**
     * Holds the name of the option.
     * @var string
     */
    private $option = '';

    /**
     * Holds the value of the field.
     * @var string
     */
    private $value = '';

    /**
     * Holds if the conditions should be accepted.
     * @var int
     */
    private $approval = self::APPROVAL_ACCEPT;

    /**
     * FilterField constructor.
     * @param string $option
     * @param string $value
     * @param int $approval
     */
    public function __construct($option, $value, $approval = self::APPROVAL_ACCEPT)
    {
        $this->setOption($option);
        $this->setValue($value);
        $this->setApproval($approval);
    }

    /**
     * Returns the name of the option.
     * @return string
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Stores the name of the option.
     * @param string $option
     * @return Field
     */
    private function setOption($option = '')
    {
        $this->option = $option;

        return $this;
    }

    /**
     * Holds the value of the option.
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Stores the value of the option.
     * @param string $value
     * @return Field
     */
    private function setValue($value = '')
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Returns if the value should be accepted or rejected.
     * @return int
     */
    public function getApproval()
    {
        return $this->approval;
    }

    /**
     * Stores if the value should be accepted or rejected.
     * @param int $approval
     * @return Field
     */
    private function setApproval($approval)
    {
        $this->approval = $approval;

        return $this;
    }

    /**
     * Returns the array presentation of the Group.
     * @return array
     */
    public function toArray()
    {
        return [
            'option'   => $this->getOption(),
            'value'    => $this->getValue(),
            'approval' => $this->getApproval()
        ];
    }
}
