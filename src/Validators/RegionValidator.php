<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class RegionValidator extends ValidatorAbstract implements ValidatorInterface
{
    protected $regex = [
        '^full$',
        '^square$',
        '[0-9]+,[0-9]+,[1-9][0-9]+,[1-9][0-9]+',
        'pct:(\d{0,2})(\.\d{1,10})?,(\d{0,2})(\.\d{1,10})?,(\d{0,2})(\.\d{1,10})?,(\d{0,2})(\.\d{1,10})?',
    ];

    public function passes($value)
    {
        $all_regex = implode('|', $this->regex);
        return preg_match('/' . $all_regex . '/', $value) ? true : false;
    }
}
