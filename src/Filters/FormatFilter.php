<?php

namespace Conlect\ImageIIIF\Filters;

use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image;

class FormatFilter implements FilterInterface
{
    private $format;

    /**
     * Creates new instance of filter
     *
     */
    public function __construct($format)
    {
        $this->format = $format;
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
        return $image->encode($this->format);
    }
}
