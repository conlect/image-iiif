<?php

namespace Conlect\ImageIIIF\Validators;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Conlect\ImageIIIF\Exceptions\NotImplementedException;
use Conlect\ImageIIIF\Validators\Contracts\ValidatorInterface;

class SizeValidator extends ValidatorAbstract implements ValidatorInterface
{
    protected $upscale;
    protected $regex = [
        ',[0-9]+',
        '\^,[0-9]+',
        '[0-9]+,',
        '\^[0-9]+,',
        '{!}?[0-9]+,[0-9]+',
    ];

    public function valid($value)
    {
        if ($value === 'max') {
            return true;
        }

        if ($value === '^max') {
            throw new NotImplementedException("Maximum size is not implemented.");
        }

        $this->upscale = str_starts_with($value, '^');

        if ($this->upscale) {
            throw new NotImplementedException("Upscaling is not allowed.");
        }

        $isPercent = str_contains($value, 'pct:');

        if ($isPercent) {
            return $this->isValidPercent($value);
        }

        $all_regex = implode('|', $this->regex);
        if (preg_match('/' . $all_regex . '/', $value)) {
            return true;
        }

        throw new BadRequestException("Size $value is invalid.");
    }

    protected function getPercentValue($value)
    {
        if ($this->upscale) {
            return preg_replace('/^\^pct:/', '', $value);
        }

        return preg_replace('/pct:/', '', $value);
    }

    protected function isValidPercent($value)
    {
        $percent_value = (int) $this->getPercentValue($value);
        if ($percent_value < 1 || ($percent_value > 100 && !$this->upscale)) {
            throw new BadRequestException("Size $value is invalid.");
        }

        return true;
    }
}
