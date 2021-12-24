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

    public function validate($value)
    {
        $options = explode(',', $value);

        if (in_array($options[0], ['full', 'square'])) {
            return true;
        }
        if (count($options) == 4 && ($options[2] == 0 || $options[3] == 0)) {
            return false;
        }

        $all_regex = implode('|', $this->regex);

        return preg_match('/' . $all_regex . '/', $value) ? true : false;
    }
}
