<?php

namespace Conlect\ImageIIIF\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

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
        // full	    The image or region is not scaled, and is returned at its full size. Note deprecation warning.
        // max	    The image or region is returned at the maximum size available, as indicated by maxWidth, maxHeight, maxArea in the profile description. This is the same as full if none of these properties are provided.
        // w,	    The image or region should be scaled so that its width is exactly equal to w, and the height will be a calculated value that maintains the aspect ratio of the extracted region.
        // ,h	    The image or region should be scaled so that its height is exactly equal to h, and the width will be a calculated value that maintains the aspect ratio of the extracted region.
        // pct:n	The width and height of the returned image is scaled to n% of the width and height of the extracted region. The aspect ratio of the returned image is the same as that of the extracted region.
        // w,h	    The width and height of the returned image are exactly w and h. The aspect ratio of the returned image may be different than the extracted region, resulting in a distorted image.
        // !w,h	    The image content is scaled for the best fit such that the resulting width and height are less than or equal to the requested width and height. The exact scaling may be determined by the service provider, based on characteristics including image quality and system performance. The dimensions of the returned image content are calculated to maintain the aspect ratio of the extracted region.

        if (in_array($this->options[0], ['full', 'max'])) {
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
        $width = $width === '' ? null : $width;
        $height = isset($this->options[1]) && $this->options[1] !== '' ? $this->options[1] : null;

        return $image->resize(
            $width, $height, function ($constraint) use ($constrainAspectRatio, $width, $height) {
                if ($constrainAspectRatio || is_null($width) || is_null($height)) {
                    $constraint->aspectRatio();
                }
            }
        );
    }
}
