<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\RotationValidator;
use PHPUnit\Framework\TestCase;

class RotationValidatorTest extends TestCase
{
    /** @test */
    public function it_validates_rotation()
    {
        $rotationValidator = new RotationValidator([]);

        $this->assertTrue($rotationValidator->valid('0'));
        $this->assertTrue($rotationValidator->valid('22.5'));
        $this->assertTrue($rotationValidator->valid('90'));
        $this->assertTrue($rotationValidator->valid('180'));
        $this->assertTrue($rotationValidator->valid('360'));
        $this->assertTrue($rotationValidator->valid('!0'));
        $this->assertTrue($rotationValidator->valid('!22.5'));
        $this->assertTrue($rotationValidator->valid('!90'));
        $this->assertTrue($rotationValidator->valid('!180'));
        $this->assertTrue($rotationValidator->valid('!360'));
    }

    /** @test */
    public function it_negative_throws_exception()
    {
        $rotation = '-90';
        $rotationValidator = new RotationValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Rotation $rotation is invalid.");
        $rotationValidator->valid($rotation);
    }

    /** @test */
    public function it_greater_than_360_throws_exception()
    {
        $rotation = '390';
        $rotationValidator = new RotationValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Rotation $rotation is invalid.");
        $rotationValidator->valid($rotation);
    }

    /** @test */
    public function it_bang_negative_throws_exception()
    {
        $rotation = '!-90';
        $rotationValidator = new RotationValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Rotation $rotation is invalid.");
        $rotationValidator->valid($rotation);
    }

    /** @test */
    public function it_greater_than_bang_360_throws_exception()
    {
        $rotation = '!390';
        $rotationValidator = new RotationValidator([]);
        $this->expectException(BadRequestException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Rotation $rotation is invalid.");
        $rotationValidator->valid($rotation);
    }
}
