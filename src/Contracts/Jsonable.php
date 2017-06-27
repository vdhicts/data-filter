<?php

namespace Vdhicts\Dicms\Filter\Contracts;

interface Jsonable
{
    /**
     * Convert the object to its JSON representation.
     * @param int $options
     * @param int $depth
     * @return string
     */
    public function toJson($options = 0, $depth = 512);
}
