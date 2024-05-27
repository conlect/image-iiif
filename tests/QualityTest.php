<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Filters\QualityFilter;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PHPUnit\Framework\TestCase;

class QualityTest extends TestCase
{
    public function test_it_returns_default()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new QualityFilter('default');
        $result = $filter->apply($image);

        $this->assertEquals($image, $result);
    }

    public function test_it_returns_color()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new QualityFilter('color');
        $result = $filter->apply($image);

        $this->assertEquals($image, $result);
    }

    public function test_it_returns_gray()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new QualityFilter('gray');
        $result = $filter->apply($image);

        // test that the image is grayscale
        $color = $result->pickColor(
            random_int(0, $result->width()),
            random_int(0, $result->height())
        )->toHex();

        // Break the color into its components
        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
        $this->assertEquals($r, $g);
        $this->assertEquals($g, $b);
    }
}
