<?php

namespace Conlect\ImageIIIF\Tests;

use Conlect\ImageIIIF\Filters\SizeFilter;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PHPUnit\Framework\TestCase;

class SizeTest extends TestCase
{
    public function test_returns_original_image_if_option_is_max()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new SizeFilter('max');
        $result = $filter->applyFilter($image);

        $this->assertSame($image, $result);
    }

    public function test_returns_pct_sizes_if_option_is_pct()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new SizeFilter('pct:50');
        $result = $filter->applyFilter($image);

        $this->assertEquals(500, $result->width());
        $this->assertEquals(500, $result->height());
    }

    public function test_returns_pct_size_if_option_is_w_h()
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read('tests/data/image.png');
        $filter = new SizeFilter('100,100');
        $result = $filter->applyFilter($image);

        $this->assertEquals(100, $result->width());
        $this->assertEquals(100, $result->height());
    }
}
