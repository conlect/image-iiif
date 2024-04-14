<?php

namespace Conlect\ImageIIIF\Filters;

use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ModifierInterface;

class QualityFilter implements ModifierInterface
{
    private $quality;

    /**
     * Creates new instance of filter
     *
     */
    public function __construct($quality)
    {
        $this->quality = $quality;
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
        if ($this->quality === 'default') {
            return $image;
        }

        if ($this->quality === 'gray') {
            return $image->greyscale();
        }

        if ($this->quality === 'color') {
            return $image;
        }

        if ($this->quality === 'bitonal') {
            return $image;
        }
    }
}
