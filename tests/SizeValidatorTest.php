<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Exceptions\NotImplementedException;
use Conlect\ImageIIIF\Validators\SizeValidator;
use Noodlehaus\Config;
use PHPUnit\Framework\TestCase;

class SizeValidatorTest extends TestCase
{
    /** @test */
    public function it_validates_size()
    {
        $config = new Config(__DIR__ . '/../config');
        $sizeValidator = new SizeValidator($config);

        // max
        $this->assertTrue($sizeValidator->valid('max'));
        // w,
        $this->assertTrue($sizeValidator->valid('20,'));
        // ^w,
        // $this->assertTrue($sizeValidator->valid('^2000,'));
        // ,h
        $this->assertTrue($sizeValidator->valid(',20'));
        // ^,h
        // $this->assertTrue($sizeValidator->valid('^,2000'));
        // pct:n
        $this->assertTrue($sizeValidator->valid('pct:100'));
        $this->assertTrue($sizeValidator->valid('pct:50'));
        // ^pct:n
        // $this->assertTrue($sizeValidator->valid('^pct:100'));
        // $this->assertTrue($sizeValidator->valid('^pct:50'));
        // $this->assertTrue($sizeValidator->valid('^pct:120'));
        // w,h
        $this->assertTrue($sizeValidator->valid('20,20'));
        // ^w,h
        // $this->assertTrue($sizeValidator->valid('^2000,2000'));
        // !w,h
        $this->assertTrue($sizeValidator->valid('!20,20'));
        // !^w,h
        // $this->assertTrue($sizeValidator->valid('!^2000,2000'));
    }

    /** @test */
    public function it_throws_exception_greater_than_100_pct()
    {
        $size = 'pct:120';
        $config = new Config(__DIR__ . '/../config');
        $sizeValidator = new SizeValidator($config);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Size $size is invalid.");
        $sizeValidator->valid($size);
    }

    /** @test */
    public function it_throws_exception_at_0_pct()
    {
        $size = 'pct:0';
        $config = new Config(__DIR__ . '/../config');
        $sizeValidator = new SizeValidator($config);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Size $size is invalid.");
        $sizeValidator->valid($size);
    }

    /** @test */
    public function it_throws_exception_not_number_pct()
    {
        $size = 'pct:hello';
        $config = new Config(__DIR__ . '/../config');
        $sizeValidator = new SizeValidator($config);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Size $size is invalid.");
        $sizeValidator->valid($size);
    }

    /** @test */
    public function it_throws_exception_caret_120_pct()
    {
        $size = '^pct:120';
        $config = new Config(__DIR__ . '/../config');
        $sizeValidator = new SizeValidator($config);
        $this->expectException(NotImplementedException::class);
        $this->expectExceptionCode(501);
        $this->expectExceptionMessage("Upscaling is not allowed.");
        $sizeValidator->valid($size);
    }

    /** @test */
    public function it_throws_exception_full()
    {
        $size = 'full';
        $config = new Config(__DIR__ . '/../config');
        $sizeValidator = new SizeValidator($config);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Size $size is invalid.");
        $sizeValidator->valid($size);
    }

    /** @test */
    public function it_throws_exception_max_size()
    {
        $size = '^max';
        $config = new Config(__DIR__ . '/../config');
        $sizeValidator = new SizeValidator($config);
        $this->expectException(NotImplementedException::class);
        $this->expectExceptionCode(501);
        $this->expectExceptionMessage("Maximum size is not implemented.");
        $sizeValidator->valid($size);
    }
}
