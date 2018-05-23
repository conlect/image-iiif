<?php

namespace Conlect\ImageIIIF\Parameters;

use Conlect\ImageIIIF\Parameters\Contracts\ParameterInterface;

class Size extends ParameterAbstract implements ParameterInterface
{
    public function apply(array $options)
    {
        // full	    The image or region is not scaled, and is returned at its full size. Note deprecation warning.
        // max	    The image or region is returned at the maximum size available, as indicated by maxWidth, maxHeight, maxArea in the profile description. This is the same as full if none of these properties are provided.
        // w,	    The image or region should be scaled so that its width is exactly equal to w, and the height will be a calculated value that maintains the aspect ratio of the extracted region.
        // ,h	    The image or region should be scaled so that its height is exactly equal to h, and the width will be a calculated value that maintains the aspect ratio of the extracted region.
        // pct:n	The width and height of the returned image is scaled to n% of the width and height of the extracted region. The aspect ratio of the returned image is the same as that of the extracted region.
        // w,h	    The width and height of the returned image are exactly w and h. The aspect ratio of the returned image may be different than the extracted region, resulting in a distorted image.
        // !w,h	    The image content is scaled for the best fit such that the resulting width and height are less than or equal to the requested width and height. The exact scaling may be determined by the service provider, based on characteristics including image quality and system performance. The dimensions of the returned image content are calculated to maintain the aspect ratio of the extracted region.

        if (in_array($options[0], ['full', 'max'])) {
            return $this->image;
        }

        if (strpos($options[0], 'pct:') !== false) {
            $percent = substr($options[0], 4);
            $width = $this->image->width() * $percent / 100;
            $height = $this->image->height() * $percent / 100;
            return $this->image->resize($width, $height);
        }


        $constrainAspectRatio = strpos($options[0], '!') !== false ? true : false;
        $width = $constrainAspectRatio ? substr($options[0], 1) : $options[0];
        $width = $width === '' ? null : $width;
        $height = isset($options[1]) && $options[1] !== '' ? $options[1] : null;

        return $this->image->resize(
            $width, $height, function ($constraint) use ($constrainAspectRatio, $width, $height) {
                if ($constrainAspectRatio || is_null($width) || is_null($height)) {
                    $constraint->aspectRatio();
                }
            }
        );
    }
}
