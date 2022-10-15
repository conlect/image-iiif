<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class QualityValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function valid($quality)
    {
        if (in_array($quality, $this->config['qualities'])) {
            return true;
        }

        throw new BadRequestException("Quality $quality is invalid.");
    }
}
