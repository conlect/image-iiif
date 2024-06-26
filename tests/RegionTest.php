<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Filters\RegionFilter;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PHPUnit\Framework\TestCase;

class RegionTest extends TestCase
{
    public function test_returns_original_image_if_option_is_full()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new RegionFilter('full');
        $result = $filter->apply($image);

        $this->assertSame($image, $result);
    }

    public function test_returns_original_image_if_option_is_square()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new RegionFilter('square');
        $result = $filter->apply($image);
        $this->assertEquals($result->width(), $result->height());
        $this->assertSame($image, $result);
    }

    public function test_returns_cropped_image_if_option_is_x_y_w_h()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new RegionFilter('100,0,100,100');
        $result = $filter->apply($image);

        $color = $result->pickColor(0, 0)->toHex();
        $this->assertEquals('c38578', $color);
        $this->assertEquals(100, $result->width());
        $this->assertEquals(100, $result->height());
    }

    public function test_returns_cropped_image_if_option_is_pct_x_y_w_h()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new RegionFilter('pct:10,0,10,10');
        $result = $filter->apply($image);

        $color = $result->pickColor(0, 0)->toHex();
        $this->assertEquals('c38578', $color);
        $this->assertEquals(100, $result->width());
        $this->assertEquals(100, $result->height());
    }
}
