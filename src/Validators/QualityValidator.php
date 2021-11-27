<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class QualityValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function fails($quality)
    {
        return in_array($quality, $this->config['qualities']);
    }
}
