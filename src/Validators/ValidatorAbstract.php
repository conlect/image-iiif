<?php

namespace Conlect\ImageIIIF\Validators;

use Intervention\Image\Image;

abstract class ValidatorAbstract
{
    protected $image;

    public function __construct($config, $image)
    {
        $this->config = $config;
        $this->image = $image;
    }
}
