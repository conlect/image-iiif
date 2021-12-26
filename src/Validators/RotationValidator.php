<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class RotationValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function validate($value)
    {
        $startValue = $value;
        $value = preg_replace('/!/', '', $value);

        if ($this->is_in_Range($value)) {
            return true;
        }

        throw new BadRequestException("Rotation $startValue is invalid.");
    }

    protected function is_in_range($value, $min = 0, $max = 360)
    {
        return (int)$value >= $min && (int)$value <= $max;
    }
}
