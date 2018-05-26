<?php

namespace Conlect\ImageIIIF\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class RegionFilter implements FilterInterface
{
    private $options;

    /**
     * Creates new instance of filter
     *
     */
    public function __construct($options)
    {
        $this->options = explode(',', $options);
    }

    /**
     * Applies filter effects to given image
     *
     * @param  Image $image
     *
     * @return  Image
     */
    public function applyFilter(Image $image)
    {
        // full	The complete image is returned, without any cropping.
        // square	The region is defined as an area where the width and height are both equal to the length of the shorter dimension of the complete image. The region may be positioned anywhere in the longer dimension of the image content at the server’s discretion, and centered is often a reasonable default.
        // x,y,w,h	The region of the full image to be returned is specified in terms of absolute pixel values. The value of x represents the number of pixels from the 0 position on the horizontal axis. The value of y represents the number of pixels from the 0 position on the vertical axis. Thus the x,y position 0,0 is the upper left-most pixel of the image. w represents the width of the region and h represents the height of the region in pixels.
        // pct:x,y,w,h	The region to be returned is specified as a sequence of percentages of the full image’s dimensions, as reported in the image information document. Thus, x represents the number of pixels from the 0 position on the horizontal axis, calculated as a percentage of the reported width. w represents the width of the region, also calculated as a percentage of the reported width. The same applies to y and h respectively. These may be floating point numbers.

        if ($this->options[0] === 'full') {
            return $image;
        }

        $height = $image->height();
        $width = $image->width();

        if ($this->options[0] === 'square') {
            $fit = $width >= $height ? $width : $height;
            return $image->fit($fit, null, null, 'center');
        }

        if (strpos($this->options[0], 'pct:') === false) {
            // iiif - x,y,w,h
            $x = $this->options[0];
            $y = $this->options[1];
            $w = $this->options[2];
            $h = $this->options[3];

            if (($x + $w) > $width) {
                $w = $w - (($x + $w) - $width);
            }

            if (($y + $h) > $height) {
                $h = $h - (($y + $h) - $height);
            }

            // intervention - w,h,x,y
            return $image->crop($x, $y, $w, $h);
        }

        // iiif - x,y,w,h
        $x = (int) round($width * substr($this->options[0], 4) / 100);
        $y = (int) round($height * $this->options[1] / 100);
        $w = (int) round($width * $this->options[2] / 100);
        $h = (int) round($height * $this->options[3] / 100);

        if ($this->options[2] + substr($this->options[0], 4) > 100) {
            $w = $width - $x;
        }

        if ($this->options[3] + $this->options[1] > 100) {
            $h = $height - $y;
        }

        // intervention - w,h,x,y
        return $image->crop($w, $h, $x, $y);
    }
}
