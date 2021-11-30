<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Validators\RegionValidator;
use PHPUnit\Framework\TestCase;
use Noodlehaus\Config;

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
        $this->assertTrue($regionValidator->passes('pct:41.6,7.5,40,70'));
        $this->assertTrue($regionValidator->passes('125,15,200,200'));
        $this->assertTrue($regionValidator->passes('pct:41.6,7.5,66.6,99'));

        $this->assertFalse($regionValidator->passes('125,15,0,0'));
        // $this->assertFalse($regionValidator->passes('pct:41,7,20,-0'));
    }  
}
