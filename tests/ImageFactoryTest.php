<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\ImageFactory;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PHPUnit\Framework\TestCase;

class ImageFactoryTest extends TestCase
{
    public function test_image_factory_returns_image()
    {
        $factory = new ImageFactory();

        $parameters = [
            "prefix" => "conlect",
            "identifier" => "1",
            "region" => "full",
            "size" => "max",
            "rotation" => "0",
            "quality" => "default",
            "format" => "png",
        ];
        $path = "tests/data/image.png";

        $manager = new ImageManager(new Driver());
        $expected = $manager->read($path);
        $expectedData = $expected->encodeByExtension('png')->toString();

        $result = $factory()->load($path)
            ->withParameters($parameters)
            ->stream();

        $resultData = $result->toString();
        // Compare the actual binary data of the images
        $this->assertEquals($expectedData, $resultData);
    }

    public function test_image_factory_returns_info()
    {
        $factory = new ImageFactory();

        $parameters = [
            "prefix" => "conlect",
            "identifier" => "1",
            "region" => "full",
            "size" => "max",
            "rotation" => "0",
            "quality" => "default",
            "format" => "png",
        ];
        $path = "tests/data/image.png";

        $info = $factory()->load($path)
            ->info($parameters['prefix'], $parameters['identifier']);

        $this->assertIsArray($info);
        $this->assertArrayHasKey('@context', $info);
        $this->assertArrayHasKey('id', $info);
        $this->assertEquals('1000', $info['width']);
        $this->assertEquals('1000', $info['height']);
    }

    public function test_image_factory_validates_parameters()
    {
        $factory = new ImageFactory();

        $parameters = [
            "prefix" => "conlect",
            "identifier" => "1",
            "region" => "full",
            "size" => "max",
            "rotation" => "0",
            "quality" => "default",
            "format" => "png",
        ];
        $path = "tests/data/image.png";

        $valid = $factory()->load($path)->hasValidParameters($parameters);

        $this->assertTrue($valid);
    }
}
