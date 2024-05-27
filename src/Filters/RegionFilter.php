<?php

namespace Conlect\ImageIIIF\Filters;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ModifierInterface;

class RegionFilter implements ModifierInterface
{
    private $options;
    private $width;
    private $height;

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
     * @param  ImageInterface $image
     *
     * @return  ImageInterface
     */
    public function apply(ImageInterface $image): ImageInterface
    {
        // full	The complete image is returned, without any cropping.
        // square	The region is defined as an area where the width and height are both equal to the length of the shorter dimension of the complete image. The region may be positioned anywhere in the longer dimension of the image content at the server’s discretion, and centered is often a reasonable default.
        // x,y,w,h	The region of the full image to be returned is specified in terms of absolute pixel values. The value of x represents the number of pixels from the 0 position on the horizontal axis. The value of y represents the number of pixels from the 0 position on the vertical axis. Thus the x,y position 0,0 is the upper left-most pixel of the image. w represents the width of the region and h represents the height of the region in pixels.
        // pct:x,y,w,h	The region to be returned is specified as a sequence of percentages of the full image’s dimensions, as reported in the image information document. Thus, x represents the number of pixels from the 0 position on the horizontal axis, calculated as a percentage of the reported width. w represents the width of the region, also calculated as a percentage of the reported width. The same applies to y and h respectively. These may be floating point numbers.

        if ($this->options[0] === 'full') {
            return $image;
        }

        $this->width = $image->width();
        $this->height = $image->height();

        if ($this->options[0] === 'square') {
            $shorter = $this->width < $this->height ? $this->width : $this->height;

            return $image->cover($shorter, $shorter, 'center');
        }

        if (strpos($this->options[0], 'pct:') === false) {
            // iiif - x,y,w,h
            $x = (int) $this->options[0];
            $y = (int) $this->options[1];
            $w = (int) $this->options[2];
            $h = (int) $this->options[3];

            if (($x + $w) > $this->width) {
                $w = $w - (($x + $w) - $this->width);
            }

            if (($y + $h) > $this->height) {
                $h = $h - (($y + $h) - $this->height);
            }

            // intervention - w,h,x,y
            return $image->crop($w, $h, $x, $y);
        }

        // iiif - x,y,w,h
        $x = (int) round($this->width * substr($this->options[0], 4) / 100);
        $y = (int) round($this->height * $this->options[1] / 100);
        $w = (int) round($this->width * $this->options[2] / 100);
        $h = (int) round($this->height * $this->options[3] / 100);

        if ($this->options[2] + substr($this->options[0], 4) > 100) {
            $w = $this->width - $x;
        }

        if ($this->options[3] + $this->options[1] > 100) {
            $h = $this->height - $y;
        }

        // intervention - w,h,x,y
        return $image->crop($w, $h, $x, $y);
    }
}
