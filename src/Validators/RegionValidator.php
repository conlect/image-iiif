<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class RegionValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function fails($region)
    {
        // check for zero
        // check if region is outside bounds

        return preg_match($this->config['regex']['region'], $region) ? false : true;
    }
}
