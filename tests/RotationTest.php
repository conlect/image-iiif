<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Filters\RotationFilter;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PHPUnit\Framework\TestCase;

class RotationTest extends TestCase
{
    public function test_returns_mirrored_image()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new RotationFilter('!0');
        $result = $filter->apply($image);

        $color = $result->pickColor(0, 0)->toHex();
        $this->assertEquals('9289b0', $color);
    }

    public function test_returns_rotated_image()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new RotationFilter('180');
        $result = $filter->apply($image);

        $color = $result->pickColor(0, 0)->toHex();
        $this->assertEquals('a177b6', $color);
    }
}
