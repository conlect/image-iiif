<?php

namespace Conlect\ImageIIIF\Parameters;

use Intervention\Image\Image;

abstract class ParameterAbstract
{
    protected $image;

    public function __construct($image)
    {
        $this->image = $image;
    }
}
