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
        $regex_size = '/^full$|^max$|,[0-9]+|[0-9]+,|{!}?[0-9]+,[0-9]+|pct:[0-9]+/';

        return preg_match($regex_size, $rotation) ? false : true;
    }
}
