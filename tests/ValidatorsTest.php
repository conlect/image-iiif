<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Validators\FormatValidator;
use Conlect\ImageIIIF\Validators\QualityValidator;
use Conlect\ImageIIIF\Validators\RegionValidator;
use Conlect\ImageIIIF\Validators\RotationValidator;
use Conlect\ImageIIIF\Validators\SizeValidator;
use Noodlehaus\Config;
use PHPUnit\Framework\TestCase;

class ValidatorsTest extends TestCase
{
    /** @test */
    public function it_validates_region()
    {
        $config = new Config(__DIR__ . '/../config');
        $regionValidator = new RegionValidator($config);
        $this->assertTrue($regionValidator->validate('full'));
        $this->assertFalse($regionValidator->validate('ful'));
        $this->assertFalse($regionValidator->validate('fulll'));

        $this->assertTrue($regionValidator->validate('square'));
        $this->assertFalse($regionValidator->validate('squares'));

        $this->assertTrue($regionValidator->validate('125,15,120,140'));
        $this->assertTrue($regionValidator->validate('125,15,200,200'));

        $this->assertTrue($regionValidator->validate('pct:41.6,7.5,40,70'));
        $this->assertTrue($regionValidator->validate('pct:41.6,7.5,66.6,100'));

        $this->assertFalse($regionValidator->validate('125,15,0,0'));
        $this->assertFalse($regionValidator->validate('125,15,20,0'));
        $this->assertFalse($regionValidator->validate('125,15,0,20'));

        $this->assertFalse($regionValidator->validate('pct:41,7,0,0'));
        $this->assertFalse($regionValidator->validate('pct:41,7,0,20'));
        $this->assertFalse($regionValidator->validate('pct:41,7,20,0'));
    }

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

    /** @test */
    public function it_validates_format()
    {
        $config = new Config(__DIR__ . '/../config');
        $formatValidator = new FormatValidator($config);

        $this->assertTrue($formatValidator->validate('jpg'));
        $this->assertTrue($formatValidator->validate('tif'));
        $this->assertTrue($formatValidator->validate('png'));
        $this->assertTrue($formatValidator->validate('gif'));
        $this->assertTrue($formatValidator->validate('jp2'));
        $this->assertTrue($formatValidator->validate('pdf'));
        $this->assertTrue($formatValidator->validate('webp'));
    }
}
