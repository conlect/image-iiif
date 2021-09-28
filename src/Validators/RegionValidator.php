<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;
use Intervention\Image\Image;

class RegionValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function fails($region)
    {
        return ! preg_match($this->config['iiif']['regex']['region'], $region);
    }
}
