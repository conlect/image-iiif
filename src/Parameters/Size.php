<?php

namespace Conlect\ImageIIIF\Parameters;

use Conlect\ImageIIIF\Filters\SizeFilter;
use Conlect\ImageIIIF\Parameters\Contracts\ParameterInterface;

class Size extends ParameterAbstract implements ParameterInterface
{
    public function apply($options)
    {
        return $this->image->filter(new SizeFilter($options));
    }
}
