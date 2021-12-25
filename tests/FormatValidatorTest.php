<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\FormatValidator;
use Noodlehaus\Config;
use PHPUnit\Framework\TestCase;

class FormatValidatorTest extends TestCase
{
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

    /** @test */
    public function it_throws_exception()
    {
        $format = 'jpeg';
        $config = new Config(__DIR__ . '/../config');
        $formatValidator = new FormatValidator($config);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Format $format is invalid.");
        $formatValidator->validate($format);
    }
}