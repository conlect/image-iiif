<?php

namespace Conlect\ImageIIIF\Filters;

use Intervention\Image\Image;

class SizeFilter implements FilterInterface
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
     * @return  Image $image
     */
    public function applyFilter(Image $image)
    {
        // TODO v3.0 support ^ or return a 501 (Not Implemented) status code
        // max	    The image or region is returned at the maximum size available, as indicated by maxWidth, maxHeight, maxArea in the profile description. This is the same as full if none of these properties are provided.
        // ^max     The extracted region is scaled to the maximum size permitted by maxWidth, maxHeight, or maxArea as defined in the Technical Properties section. If the resulting dimensions are greater than the pixel width and height of the extracted region, the extracted region is upscaled.
        // w,	    The image or region should be scaled so that its width is exactly equal to w, and the height will be a calculated value that maintains the aspect ratio of the extracted region.
        // ^w,      The extracted region should be scaled so that the width of the returned image is exactly equal to w. If w is greater than the pixel width of the extracted region, the extracted region is upscaled.
        // ,h	    The image or region should be scaled so that its height is exactly equal to h, and the width will be a calculated value that maintains the aspect ratio of the extracted region.
        // ^,h      The extracted region should be scaled so that the height of the returned image is exactly equal to h. If h is greater than the pixel height of the extracted region, the extracted region is upscaled.
        // pct:n	The width and height of the returned image is scaled to n% of the width and height of the extracted region. The aspect ratio of the returned image is the same as that of the extracted region.
        // ^pct:n   The width and height of the returned image is scaled to n percent of the width and height of the extracted region. For values of n greater than 100, the extracted region is upscaled.
        // w,h	    The width and height of the returned image are exactly w and h. The aspect ratio of the returned image may be different than the extracted region, resulting in a distorted image.
        // ^w,h     The width and height of the returned image are exactly w and h. The aspect ratio of the returned image may be significantly different than the extracted region, resulting in a distorted image. If w and/or h are greater than the corresponding pixel dimensions of the extracted region, the extracted region is upscaled.
        // !w,h	    The image content is scaled for the best fit such that the resulting width and height are less than or equal to the requested width and height. The exact scaling may be determined by the service provider, based on characteristics including image quality and system performance. The dimensions of the returned image content are calculated to maintain the aspect ratio of the extracted region.
        // ^!w,h    The extracted region is scaled so that the width and height of the returned image are not greater than w and h, while maintaining the aspect ratio. The returned image must be as large as possible but not larger than w, h, or server-imposed limits.

        if (in_array($this->options[0], ['max'])) {
            return $image;
        }

        if (strpos($this->options[0], 'pct:') !== false) {
            $percent = substr($this->options[0], 4);
            $width = $image->width() * $percent / 100;
            $height = $image->height() * $percent / 100;

            return $image->resize($width, $height);
        }

        $constrainAspectRatio = strpos($this->options[0], '!') !== false ? true : false;
        $width = $constrainAspectRatio ? substr($this->options[0], 1) : $this->options[0];
        $width = $width === '' ? null : intval($width);
        $height = isset($this->options[1]) && $this->options[1] !== '' ? intval($this->options[1]) : null;

        // TODO intervention 3.0 doesn't have a callback for aspect ratio
        return $image->resize(
            $width,
            $height,
            function ($constraint) use ($constrainAspectRatio, $width, $height) {
                if ($constrainAspectRatio || is_null($width) || is_null($height)) {
                    $constraint->aspectRatio();
                }
            }
        );
    }
}
