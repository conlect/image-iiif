<?php

namespace Conlect\ImageIIIF\Filters;

use Intervention\Image\Interfaces\ModifierInterface;
use Intervention\Image\Interfaces\ImageInterface;

class RotationFilter implements ModifierInterface
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
     * @param  ImageInterface $image
     *
     * @return  ImageInterface
     */
    public function apply(ImageInterface $image): ImageInterface
    {
        // transparent background if possible

        $mirror = strpos($this->rotation, '!') === false ? false : true;
        $rotation = $mirror ? substr($this->rotation, 1) : $this->rotation;
        if ($mirror) {
            $image->flop();
        }

        return $image->rotate(-$rotation);
    }
}
