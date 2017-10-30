<?php

namespace Vdhicts\Dicms\Filter\Exceptions;

use Exception;
use Vdhicts\Dicms\Filter\FilterException;

class InvalidOrderField extends FilterException
{
    /**
     * InvalidOrderField constructor.
     * @param string $field
     * @param Exception|null $previous
     */
    public function __construct($field, Exception $previous = null)
    {
        parent::__construct(
            sprintf('Invalid field provided, it must be a string and filled'),
            0,
            $previous
        );
    }
}
