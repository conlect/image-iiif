<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class FormatValidator extends ValidatorAbstract implements ValidatorInterface
{
    use \Conlect\ImageIIIF\Traits\SupportedFormats;

    public function valid($format)
    {
        $formats = $this->getSupportedFormats($this->config['driver']);

        if (in_array($format, $formats)) {
            return true;
        }

        throw new BadRequestException("Format $format is invalid.");
    }
}
