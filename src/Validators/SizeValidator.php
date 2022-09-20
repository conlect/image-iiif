<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class SizeValidator extends ValidatorAbstract implements ValidatorInterface
{
    protected $regex = [
        '^max$',
        '^\^max$',
        ',[0-9]+',
        '\^,[0-9]+',
        '[0-9]+,',
        '\^[0-9]+,',
        '{!}?[0-9]+,[0-9]+',
    ];

    public function valid($value)
    {
        $startValue = $value;

        if (strpos($value, '^pct:') !== false) {
            $value = preg_replace('/^\^pct:/', '', $value);

            if ((int)$value == 0) {
                throw new BadRequestException("Size $startValue is invalid.");
            }
            if ((int)$value >= 1) {
                return true;
            }
        }

        if (strpos($value, 'pct:') !== false) {
            $value = preg_replace('/pct:/', '', $value);

            if ((int)$value == 0 || (int)$value > 100) {
                throw new BadRequestException("Size $startValue is invalid.");
            }
            if ((int)$value >= 1 && (int)$value <= 100) {
                return true;
            }
        }

        $all_regex = implode('|', $this->regex);

        if (preg_match('/' . $all_regex . '/', $value)) {
            return true;
        }

        throw new BadRequestException("Size $startValue is invalid.");
    }
}
