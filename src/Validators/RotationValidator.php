<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class RotationValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function fails($rotation)
    {
        return preg_match($this->config['regex']['rotation'], $rotation) ? false : true;
    }
}
