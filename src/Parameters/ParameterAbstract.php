<?php

namespace Conlect\ImageIIIF\Parameters;

abstract class ParameterAbstract
{
    protected $image;

    public function __construct($image)
    {
        $this->image = $image;
    }
}
