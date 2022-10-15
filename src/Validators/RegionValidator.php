<?php

namespace Conlect\ImageIIIF\Validators;

use function array_filter;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

use function count;
use function explode;
use function in_array;
use function str_starts_with;

class RegionValidator extends ValidatorAbstract implements ValidatorInterface
{
    public function valid($value)
    {
        $options = explode(',', $value);

        if (count($options) == 1) {
            return $this->validateFullOrSquare($options[0]);
        }

        if (count($options) !== 4) {
            return $this->valueException($value);
        }

        if ($options[2] == 0 || $options[3] == 0) {
            return $this->zeroException();
        }

        if (str_starts_with($options[0], 'pct:')) {
            $options[0] = \substr($options[0], 4);
        }

        if (4 === count(array_filter($options, 'is_numeric'))) {
            $validator = new ValidatorShared();
            foreach ($options as $option) {
                $validator->floatingPointValidator($option);
            }

            return true;
        }


        return $this->valueException($value);
    }

    protected function validateFullOrSquare($value)
    {
        if (in_array($value, ['full', 'square'])) {
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
