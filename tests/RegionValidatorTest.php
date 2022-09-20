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
        $this->assertTrue($regionValidator->valid('full'));
        $this->assertTrue($regionValidator->valid('square'));
        $this->assertTrue($regionValidator->valid('125,15,120,140'));
        $this->assertTrue($regionValidator->valid('125,15,200,200'));
        $this->assertTrue($regionValidator->valid('pct:41.6,7.5,40,70'));
        $this->assertTrue($regionValidator->valid('pct:41.6,7.5,66.6,100'));
    }

    /** @test */
    public function it_ful_throws_exception()
    {
        $region = 'ful';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");
        $valid = $regionValidator->valid($region);
    }

    /** @test */
    public function it_throws_square_exception()
    {
        $region = 'sq';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");

        $regionValidator->valid($region);
    }

    /** @test */
    public function it_missing_comma_throws_exception()
    {
        $region = '125,15,200200';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");
        $valid = $regionValidator->valid($region);
    }

    /** @test */
    public function it_non_numeric_throws_exception()
    {
        $region = '125,15,hello,200';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");
        $valid = $regionValidator->valid($region);
    }

    /** @test */
    public function it_wrong_pct_throws_exception()
    {
        $region = 'pc:41.6,7.5,40,70';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");
        $valid = $regionValidator->valid($region);
    }

    /** @test */
    public function it_pct_missing_comma_throws_exception()
    {
        $region = 'pct:41.6,7.5,4070';
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Region $region is invalid.");
        $valid = $regionValidator->valid($region);
    }

    /** @test */
    public function it_throws_zero_width_exception()
    {
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Region width and height should be greater than zero.');
        $regionValidator->valid('125,15,0,20');
    }

    /** @test */
    public function it_throws_zero_height_exception()
    {
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Region width and height should be greater than zero.');
        $regionValidator->valid('125,15,20,0');
    }

    /** @test */
    public function it_throws_pct_zero_width_exception()
    {
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Region width and height should be greater than zero.');
        $regionValidator->valid('pct:41,7,0,20');
    }

    /** @test */
    public function it_throws_pct_zero_height_exception()
    {
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Region width and height should be greater than zero.');
        $regionValidator->valid('pct:41,7,20,0');
    }

    /** @test */
    public function it_throws_no_leading_zero()
    {
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Region values less than one require a leading zero.');
        $regionValidator->valid('.9,15,120,140');
    }

    /** @test */
    public function it_throws_no_trailing_zero()
    {
        $regionValidator = new RegionValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Region values should not contain a trailing zero.');
        $regionValidator->valid('0.90,15,120,140');
    }
}
