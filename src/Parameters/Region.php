<?php

namespace Conlect\ImageIIIF\Parameters;

use Conlect\ImageIIIF\Filters\RegionFilter;
use Conlect\ImageIIIF\Parameters\Contracts\ParameterInterface;

class Region extends ParameterAbstract implements ParameterInterface
{
    public function apply($options)
    {
        return $this->image->filter(new RegionFilter($options));
    }
}
