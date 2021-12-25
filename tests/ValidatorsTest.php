<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Validators\QualityValidator;
use Conlect\ImageIIIF\Validators\RotationValidator;
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

    /** @test */
    public function it_validates_rotation()
    {
        $config = new Config(__DIR__ . '/../config');
        $rotationValidator = new RotationValidator($config);

        // n
        $this->assertTrue($rotationValidator->validate('0'));
        $this->assertTrue($rotationValidator->validate('22.5'));
        $this->assertTrue($rotationValidator->validate('90'));
        $this->assertTrue($rotationValidator->validate('180'));
        $this->assertTrue($rotationValidator->validate('360'));
        $this->assertFalse($rotationValidator->validate('363'));
        $this->assertFalse($rotationValidator->validate('-90'));
        // !n
        $this->assertTrue($rotationValidator->validate('!0'));
        $this->assertTrue($rotationValidator->validate('!22.5'));
        $this->assertTrue($rotationValidator->validate('!90'));
        $this->assertTrue($rotationValidator->validate('!180'));
        $this->assertTrue($rotationValidator->validate('!360'));
        // $this->assertFalse($rotationValidator->validate('!363'));
        $this->assertFalse($rotationValidator->validate('!-90'));
    }

    /** @test */
    public function it_validates_quality()
    {
        $config = new Config(__DIR__ . '/../config');
        $qualityValidator = new QualityValidator($config);

        $this->assertTrue($qualityValidator->validate('color'));
        $this->assertTrue($qualityValidator->validate('gray'));
        $this->assertTrue($qualityValidator->validate('bitonal'));
        $this->assertTrue($qualityValidator->validate('default'));

        $this->assertFalse($qualityValidator->validate('colour'));
        $this->assertFalse($qualityValidator->validate('grey'));
        $this->assertFalse($qualityValidator->validate('bytonal'));
        $this->assertFalse($qualityValidator->validate('dabears'));
    }
}
