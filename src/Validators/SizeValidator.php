<?php

namespace Conlect\ImageIIIF\Validators;

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
        'pct:[0-9]+',
    ];

    public function passes($value)
    {
        if (strpos($value, '^pct:') !== false) {
            $percent = preg_replace('/^\^pct:/', '', $value);

            return (int)$percent >= 1;
        }

        if (strpos($value, 'pct:') !== false) {
            $percent = preg_replace('/^pct:/', '', $value);
            return (int)$percent >= 1 && (int)$percent <= 100;
        }

        $all_regex = implode('|', $this->regex);

        return preg_match('/' . $all_regex . '/', $value) ? true : false;
    }
}
