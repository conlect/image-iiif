<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Validators\RegionValidator;
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
        $this->assertTrue($regionValidator->passes('full'));
        $this->assertFalse($regionValidator->passes('ful'));
        $this->assertFalse($regionValidator->passes('fulll'));

        $this->assertTrue($regionValidator->passes('square'));
        $this->assertFalse($regionValidator->passes('squares'));

        $this->assertTrue($regionValidator->passes('125,15,120,140'));
        $this->assertTrue($regionValidator->passes('125,15,200,200'));

        $this->assertTrue($regionValidator->passes('pct:41.6,7.5,40,70'));
        $this->assertTrue($regionValidator->passes('pct:41.6,7.5,66.6,100'));

        $this->assertFalse($regionValidator->passes('125,15,0,0'));
        $this->assertFalse($regionValidator->passes('125,15,20,0'));
        $this->assertFalse($regionValidator->passes('125,15,0,20'));

        $this->assertFalse($regionValidator->passes('pct:41,7,0,0'));
        $this->assertFalse($regionValidator->passes('pct:41,7,0,20'));
        $this->assertFalse($regionValidator->passes('pct:41,7,20,0'));
    }

    /** @test */
    public function it_validates_size()
    {
        $config = new Config(__DIR__ . '/../config');
        $sizeValidator = new SizeValidator($config);

        // max
        $this->assertTrue($sizeValidator->passes('max'));
        // ^max
        $this->assertTrue($sizeValidator->passes('^max'));
        // w,
        $this->assertTrue($sizeValidator->passes('20,'));
        // ^w,
        $this->assertTrue($sizeValidator->passes('^2000,'));
        // ,h
        $this->assertTrue($sizeValidator->passes(',20'));
        // ^,h
        $this->assertTrue($sizeValidator->passes('^,2000'));
        // pct:n
        $this->assertTrue($sizeValidator->passes('pct:100'));
        $this->assertTrue($sizeValidator->passes('pct:50'));
        $this->assertFalse($sizeValidator->passes('pct:120'));
        $this->assertFalse($sizeValidator->passes('pct:0'));
        // ^pct:n
        $this->assertTrue($sizeValidator->passes('^pct:100'));
        $this->assertTrue($sizeValidator->passes('^pct:50'));
        $this->assertTrue($sizeValidator->passes('^pct:120'));
        $this->assertFalse($sizeValidator->passes('^pct:0'));
        // w,h
        $this->assertTrue($sizeValidator->passes('20,20'));
        // ^w,h
        $this->assertTrue($sizeValidator->passes('^2000,2000'));
        // !w,h
        $this->assertTrue($sizeValidator->passes('!20,20'));
        // !^w,h
        $this->assertTrue($sizeValidator->passes('!^2000,2000'));
    }
}
