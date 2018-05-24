<?php

namespace Conlect\ImageIIIF\Parameters;

use Conlect\ImageIIIF\Parameters\Contracts\ParameterInterface;

class Region extends ParameterAbstract implements ParameterInterface
{
    public function apply(array $options)
    {
        // full	The complete image is returned, without any cropping.
        // square	The region is defined as an area where the width and height are both equal to the length of the shorter dimension of the complete image. The region may be positioned anywhere in the longer dimension of the image content at the server’s discretion, and centered is often a reasonable default.
        // x,y,w,h	The region of the full image to be returned is specified in terms of absolute pixel values. The value of x represents the number of pixels from the 0 position on the horizontal axis. The value of y represents the number of pixels from the 0 position on the vertical axis. Thus the x,y position 0,0 is the upper left-most pixel of the image. w represents the width of the region and h represents the height of the region in pixels.
        // pct:x,y,w,h	The region to be returned is specified as a sequence of percentages of the full image’s dimensions, as reported in the image information document. Thus, x represents the number of pixels from the 0 position on the horizontal axis, calculated as a percentage of the reported width. w represents the width of the region, also calculated as a percentage of the reported width. The same applies to y and h respectively. These may be floating point numbers.

        if ($options[0] === 'full') {
            return $this->image;
        }

        $height = $this->image->height();
        $width = $this->image->width();

        if ($options[0] === 'square') {
            $fit = $width >= $height ? $width : $height;
            return $this->image->fit($fit, null, null, 'center');
        }

        if (strpos($options[0], 'pct:') === false) {
            // iiif - x,y,w,h
            // intervention - w,h,x,y
            return $this->image->crop($options[2], $options[3], $options[0], $options[1]);
        }

        $x = $width * $options[2] / 100;
        $y = $height * $options[3] / 100;
        $w = $width * substr($options[0], 4) / 100;
        $h = $height * $options[1] / 100;
        // dd($width); // 2800
        // dd($x + $w);

        return $this->image->crop($x, $y, $w, $h);



    }
}
