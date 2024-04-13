<?php

namespace Conlect\ImageIIIF\Filters;

use Intervention\Image\Image;

class RotationFilter implements FilterInterface
{
    private $rotation;

    /**
     * Creates new instance of filter
     *
     */
    public function __construct($rotation)
    {
        $this->rotation = $rotation;
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
        // transparent background if possible

        $mirror = strpos($this->rotation, '!') === false ? false : true;
        $rotation = $mirror ? substr($this->rotation, 1) : $this->rotation;
        if ($mirror) {
            $image->flip('h');
        }

        return $image->rotate(-$rotation);
    }
}
