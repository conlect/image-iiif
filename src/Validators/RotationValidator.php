<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class RotationValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function passes($value)
    {
        if (strpos($value, '!') !== false) {
            $value = preg_replace('/!/', '', $value);
            return (int)$value >= 0 && (int)$value <= 360;
        }

        return (int)$value >= 0 && (int)$value <= 360;
    }
}
