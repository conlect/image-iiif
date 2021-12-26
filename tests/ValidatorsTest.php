<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Validators\SizeValidator;
use Noodlehaus\Config;
use PHPUnit\Framework\TestCase;

class ValidatorsTest extends TestCase
{
    /** @test */
    public function it_validates_size()
    {
        $config = new Config(__DIR__ . '/../config');
        $sizeValidator = new SizeValidator($config);

        // max
        $this->assertTrue($sizeValidator->validate('max'));
        // ^max
        $this->assertTrue($sizeValidator->validate('^max'));
        // w,
        $this->assertTrue($sizeValidator->validate('20,'));
        // ^w,
        $this->assertTrue($sizeValidator->validate('^2000,'));
        // ,h
        $this->assertTrue($sizeValidator->validate(',20'));
        // ^,h
        $this->assertTrue($sizeValidator->validate('^,2000'));
        // pct:n
        $this->assertTrue($sizeValidator->validate('pct:100'));
        $this->assertTrue($sizeValidator->validate('pct:50'));
        $this->assertFalse($sizeValidator->validate('pct:120'));
        $this->assertFalse($sizeValidator->validate('pct:0'));
        // ^pct:n
        $this->assertTrue($sizeValidator->validate('^pct:100'));
        $this->assertTrue($sizeValidator->validate('^pct:50'));
        $this->assertTrue($sizeValidator->validate('^pct:120'));
        $this->assertFalse($sizeValidator->validate('^pct:0'));
        // w,h
        $this->assertTrue($sizeValidator->validate('20,20'));
        // ^w,h
        $this->assertTrue($sizeValidator->validate('^2000,2000'));
        // !w,h
        $this->assertTrue($sizeValidator->validate('!20,20'));
        // !^w,h
        $this->assertTrue($sizeValidator->validate('!^2000,2000'));
    }
}
