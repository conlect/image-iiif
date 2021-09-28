<?php

namespace Conlect\ImageIIIF\Filters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class QualityFilter implements FilterInterface
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
     * @param  Image $image
     *
     * @return  Image
     */
    public function applyFilter(Image $image)
    {
        if ($this->quality === 'default') {
            $this->quality = config('iiif.quality_default');
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
