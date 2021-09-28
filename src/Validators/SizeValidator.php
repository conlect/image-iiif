<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;
use Intervention\Image\Image;

class SizeValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function fails($rotation)
    {
        return ! preg_match($this->config['regex']['size'], $rotation);
    }
}
