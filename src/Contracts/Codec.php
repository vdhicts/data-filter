<?php

namespace Vdhicts\Dicms\Filter\Contracts;

interface Codec
{
    /**
     * Returns the encoded string.
     * @param string $string
     * @param int $mode
     * @return string
     */
    public function encode($string, $mode = 0);

    /**
     * Returns the decoded string.
     * @param string $string
     * @param int $mode
     * @return string
     */
    public function decode($string, $mode = 0);
}
