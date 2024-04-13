<?php

namespace Conlect\ImageIIIF\Tests;

use PHPUnit\Framework\TestCase;
use Conlect\ImageIIIF\Filters\RegionFilter;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class RegionTest extends TestCase
{
    public function test_returns_original_image_if_option_is_full()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new RegionFilter('full');
        $result = $filter->applyFilter($image);

        $this->assertSame($image, $result);
    }

    public function test_returns_original_image_if_option_is_square()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new RegionFilter('square');
        $result = $filter->applyFilter($image);
        $this->assertEquals($result->width(), $result->height());
        $this->assertSame($image, $result);
    }

    public function test_returns_cropped_image_if_option_is_x_y_w_h()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new RegionFilter('100,0,100,100');
        $result = $filter->applyFilter($image);

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
        $result = $filter->applyFilter($image);

        $color = $result->pickColor(0, 0)->toHex();
        $this->assertEquals('c38578', $color);
        $this->assertEquals(100, $result->width());
        $this->assertEquals(100, $result->height());
    }
}
