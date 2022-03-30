<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\QualityValidator;
use Noodlehaus\Config;
use PHPUnit\Framework\TestCase;

class QualityValidatorTest extends TestCase
{
    /** @test */
    public function it_validates_format()
    {
        $config = new Config(__DIR__ . '/../config');
        $qualityValidator = new QualityValidator($config);

        $this->assertTrue($qualityValidator->valid('color'));
        $this->assertTrue($qualityValidator->valid('gray'));
        $this->assertTrue($qualityValidator->valid('bitonal'));
        $this->assertTrue($qualityValidator->valid('default'));
    }

    /** @test */
    public function it_throws_exception()
    {
        $quality = 'grey';
        $config = new Config(__DIR__ . '/../config');
        $qualityValidator = new QualityValidator($config);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Quality $quality is invalid.");
        $qualityValidator->valid($quality);
    }
}
