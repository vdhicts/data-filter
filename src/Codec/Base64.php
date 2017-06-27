<?php

namespace Vdhicts\Dicms\Filter\Codec;

use Vdhicts\Dicms\Filter\Codec\Exceptions\CodecModeException;
use Vdhicts\Dicms\Filter\Contracts\Codec AS CodecContract;

/**
 * Class Base64
 * @package Vdhicts\Dicms\Filter\Codec
 */
class Base64 extends Codec implements CodecContract
{
    /**
     * Returns the base64 encoded string.
     * @param string $data
     * @return string
     */
    private function getStringEncoded($data)
    {
        return base64_encode($data);
    }

    /**
     * Returns the url safe presentation of the encoded string.
     * @param string $encodedData
     * @return string
     */
    private function getUrlSafeEncodedString($encodedData)
    {
        return rtrim(strtr($encodedData, '+/', '-_'), '=');
    }

    /**
     * Returns the encoded string.
     * @param string $string
     * @param int $mode
     * @return string
     * @throws CodecModeException
     */
    public function encode($string, $mode = self::MODE_NORMAL)
    {
        switch ($mode) {
            case self::MODE_NORMAL :
                return $this->getStringEncoded($string);
            case self::MODE_URL_SAFE :
                $encodedData = $this->getStringEncoded($string);
                return $this->getUrlSafeEncodedString($encodedData);
        }

        throw new CodecModeException('Invalid mode provided, please use the provided constants');
    }

    /**
     * Returns the base64 decoded string.
     * @param string $string
     * @return bool|string
     */
    private function getStringDecoded($string)
    {
        return base64_decode($string);
    }

    /**
     * Returns the url safe decoded string.
     * @param string $string
     * @return string
     */
    private function getUrlSafeDecodedString($string)
    {
        return str_pad(strtr($string, '-_', '+/'), strlen($string) % 4, '=',STR_PAD_RIGHT);
    }

    /**
     * Returns the decoded string.
     * @param $string
     * @param int $mode
     * @return string
     * @throws CodecModeException
     */
    public function decode($string, $mode = self::MODE_NORMAL)
    {
        switch ($mode) {
            case self::MODE_NORMAL :
                return $this->getStringDecoded($string);
            case self::MODE_URL_SAFE :
                return $this->getStringDecoded($this->getUrlSafeDecodedString($string));
        }

        throw new CodecModeException('Invalid mode provided, please use the provided constants');
    }
}