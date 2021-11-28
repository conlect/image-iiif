<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class RegionValidator extends ValidatorAbstract implements ValidatorInterface
{
    protected $regex = '/^full$|^square$|[0-9]+,[0-9]+,[0-9]+,[0-9]+|pct:(\d{0,2})(\.\d{1,10})?,(\d{0,2})(\.\d{1,10})?,(\d{0,2})(\.\d{1,10})?,(\d{0,2})(\.\d{1,10})?/';

    public function fails($region)
    {
        // check for zero
        // check if region is outside bounds

        return preg_match($this->regex, $region) ? false : true;
    }
}
