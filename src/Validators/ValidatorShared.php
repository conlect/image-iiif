<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Exceptions\BadRequestException;

class ValidatorShared
{
    public function floatingPointValidator(string $value)
    {
        if (is_float($value + 0)) {
            // if less than zero and doesn't start with a zero
            if ($value + 0 < 1 && !str_starts_with($value, '0')) {
                throw new BadRequestException('Region values less than one require a leading zero.');
            }
            // option should not have an extra trailing zero
            if (str_ends_with($value, '0')) {
                throw new BadRequestException('Region values should not contain a trailing zero.');
            }
        }

        return true;
    }
}
