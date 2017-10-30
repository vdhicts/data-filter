<?php

namespace Vdhicts\Dicms\Filter\Exceptions;

use Exception;
use Vdhicts\Dicms\Filter\FilterException;

class InvalidOrderDirection extends FilterException
{
    /**
     * InvalidOrderDirection constructor.
     * @param string $direction
     * @param array $supportedDirections
     * @param Exception|null $previous
     */
    public function __construct($direction, array $supportedDirections, Exception $previous = null)
    {
        parent::__construct(
            sprintf(
                'Direction `%s` not supported, please use on of the `%s` directions',
                $direction,
                implode(', ', $supportedDirections)
            ),
            0,
            $previous
        );
    }
}
