<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;
use Intervention\Image\Image;

class SizeValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function fails($rotation)
    {
        // check if not ^ that the image will not be upscaled
        // support upscaling or 501 not supported
        // check max supported scale (add to config)
        // check not less than

        return preg_match($this->config['regex']['size'], $rotation) ? false : true;
    }
}
