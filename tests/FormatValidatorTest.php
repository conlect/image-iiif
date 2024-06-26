<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\FormatValidator;
use Noodlehaus\Config;
use PHPUnit\Framework\TestCase;

class FormatValidatorTest extends TestCase
{
    /** @test */
    public function it_validates_format_gd()
    {
        $config = new Config(__DIR__ . '/../config');
        $formatValidator = new FormatValidator($config);

        $this->assertTrue($formatValidator->valid('jpg'));
        $this->assertTrue($formatValidator->valid('png'));
        $this->assertTrue($formatValidator->valid('gif'));
        $this->assertTrue($formatValidator->valid('webp'));
    }

    public function it_validates_format_imagick()
    {
        $config = new Config(__DIR__ . '/../config');
        $config["driver"] = "imagick";
        $formatValidator = new FormatValidator($config);

        $this->assertTrue($formatValidator->valid('jpg'));
        $this->assertTrue($formatValidator->valid('png'));
        $this->assertTrue($formatValidator->valid('gif'));
        $this->assertTrue($formatValidator->valid('webp'));
        $this->assertTrue($formatValidator->valid('tif'));
        $this->assertTrue($formatValidator->valid('jp2'));
    }

    /** @test */
    public function it_throws_exception()
    {
        $format = 'jpeg';
        $config = new Config(__DIR__ . '/../config');
        $formatValidator = new FormatValidator($config);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Format $format is invalid.");
        $formatValidator->valid($format);
    }
}
