<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\RegionValidator;
use PHPUnit\Framework\TestCase;

class RegionValidatorTest extends TestCase
{
    /** @test */
    public function it_validates_region()
    {
        $regionValidator = new RegionValidator([]);
        $this->assertTrue($regionValidator->validate('full'));
        $this->assertTrue($regionValidator->validate('square'));
        $this->assertTrue($regionValidator->validate('125,15,120,140'));
        $this->assertTrue($regionValidator->validate('125,15,200,200'));
        $this->assertTrue($regionValidator->validate('pct:41.6,7.5,40,70'));
        $this->assertTrue($regionValidator->validate('pct:41.6,7.5,66.6,100'));
    }

    /** @test */
    public function it_ful_throws_exception()
    {
        $region = 'ful';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");
        $valid = $regionValidator->validate($region);
    }

    /** @test */
    public function it_throws_square_exception()
    {
        $region = 'sq';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");

        $regionValidator->validate($region);
    }

    /** @test */
    public function it_missing_comma_throws_exception()
    {
        $region = '125,15,200200';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");
        $valid = $regionValidator->validate($region);
    }

    /** @test */
    public function it_wrong_pct_throws_exception()
    {
        $region = 'pc:41.6,7.5,40,70';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");
        $valid = $regionValidator->validate($region);
    }

    /** @test */
    public function it_pct_missing_comma_throws_exception()
    {
        $region = 'pct:41.6,7.5,4070';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");
        $valid = $regionValidator->validate($region);
    }

    /** @test */
    public function it_throws_zero_width_exception()
    {
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Region width and height should be greater than zero.');
        $regionValidator->validate('125,15,0,20');
    }

    /** @test */
    public function it_throws_zero_height_exception()
    {
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Region width and height should be greater than zero.');
        $regionValidator->validate('125,15,20,0');
    }

    /** @test */
    public function it_throws_pct_zero_width_exception()
    {
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Region width and height should be greater than zero.');
        $regionValidator->validate('pct:41,7,0,20');
    }

    /** @test */
    public function it_throws_pct_zero_height_exception()
    {
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Region width and height should be greater than zero.');
        $regionValidator->validate('pct:41,7,20,0');
    }
}
