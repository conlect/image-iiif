<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
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

        if (str_contains($options[0], ':') && !str_starts_with($options[0], 'pct:')) {
            throw new BadRequestException("Region $value is invalid.");     
        }

        if (count($options) !== 4) {
            throw new BadRequestException("Region $value is invalid.");
        }

        if ($options[2] == 0 || $options[3] == 0) {
            throw new BadRequestException('Region width and height should be greater than zero.');
        }

        if (str_starts_with($options[0], 'pct:')) {
            $options[0] = substr($options[0], 4);
        }

        if (4 === count(array_filter($options, 'is_numeric'))) {
            return true;
        }
    }
}
