<?php

namespace Conlect\ImageIIIF\Validators;

use Noodlehaus\Config;
use Intervention\Image\Image;

class FormatValidator
{
    private $format;

    public function __construct($format)
    {
        $this->format = $format;
    }

    public function fails(Config $config, Image $image)
    {
        return in_array($this->format, $config['formats']);
    }
}
