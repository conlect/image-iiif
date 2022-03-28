<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class RegionValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function valid($value)
    {
        $options = explode(',', $value);

        if (in_array($options[0], ['full', 'square'])) {
            return true;
        }

        if (str_contains($options[0], ':') && ! str_starts_with($options[0], 'pct:')) {
            return $this->valueException($value);
        }

        if (count($options) !== 4) {
            return $this->valueException($value);
        }

        if ($options[2] == 0 || $options[3] == 0) {
            return $this->zeroException();
        }

        if (str_starts_with($options[0], 'pct:')) {
            $options[0] = substr($options[0], 4);
        }

        if (4 === count(array_filter($options, 'is_numeric'))) {
            return true;
        }

        return $this->valueException($value);
    }

    protected function valueException($value)
    {
        throw new BadRequestException("Region $value is invalid.");
    }

    protected function zeroException()
    {
        throw new BadRequestException('Region width and height should be greater than zero.');
    }
}
