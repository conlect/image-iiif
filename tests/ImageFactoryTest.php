<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\ImageFactory;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PHPUnit\Framework\TestCase;

class ImageFactoryTest extends TestCase
{
    public function testFactory()
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
        $image = $manager->read($path);
        $image = $image->encodeByExtension('png');

        $result = $factory()->load($path)
            ->withParameters($parameters)
            ->stream();

        $this->assertEquals($image, $result);
    }
}
