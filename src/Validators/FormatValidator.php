<?php

namespace Conlect\ImageIIIF\Validators;

use Intervention\Image\Image;

class FormatValidator
{
    private $format;

    public function __construct($format)
    {
        $this->format = $format;
    }

    public function fails($config, Image $image)
    {
        return in_array($this->format, $config['formats']);
    }
}
