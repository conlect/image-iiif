<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class RotationValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function passes($rotation)
    {
        $regex_rotation = '!([0-2]?[0-9]{1,2}|3[0-5][0-9]|360)|([0-2]?[0-9]{1,2}|3[0-5][0-9]|360)';

        return preg_match($regex_rotation, $rotation) ? false : true;
    }
}
