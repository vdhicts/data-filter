<?php

use PHPUnit\Framework\TestCase;
use Vdhicts\Dicms\Filter\Codec\Base64;
use Vdhicts\Dicms\Filter\Codec\Codec;
use Vdhicts\Dicms\Filter\Codec\Exceptions\CodecModeException;

class CodecTest extends TestCase
{
    public function testBase64()
    {
        $this->assertTrue(class_exists(Codec::class));
        $this->assertTrue(class_exists(Base64::class));

        $codec = new Base64();

        $encodedData = $codec->encode('Hello World');
        $this->assertSame('SGVsbG8gV29ybGQ=', $encodedData);

        $urlSafeEncodedData = $codec->encode('Hello World', Codec::MODE_URL_SAFE);
        $this->assertSame('SGVsbG8gV29ybGQ', $urlSafeEncodedData);

        $decodedData = $codec->decode($encodedData);
        $this->assertSame('Hello World', $decodedData);

        $urlSafeDecodedData = $codec->decode($urlSafeEncodedData, Codec::MODE_URL_SAFE);
        $this->assertSame('Hello World', $urlSafeDecodedData);
    }

    public function testEncodeException()
    {
        $codec = new Base64();

        $this->expectException(CodecModeException::class);
        $codec->encode('Hello World', 123);
    }

    public function testDecodeException()
    {
        $codec = new Base64();

        $this->expectException(CodecModeException::class);
        $codec->decode('Hello World', 123);
    }
}
