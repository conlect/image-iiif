<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;
use Intervention\Image\Image;

class QualityValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function fails($quality)
    {
        return in_array($quality, $this->config['qualities']);
    }
}
