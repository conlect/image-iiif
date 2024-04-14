<?php

namespace Conlect\ImageIIIF\Parameters;

use Conlect\ImageIIIF\Filters\QualityFilter;
use Conlect\ImageIIIF\Parameters\Contracts\ParameterInterface;

class Quality extends ParameterAbstract implements ParameterInterface
{
    public function apply($options)
    {
        return $this->image->modify(new QualityFilter($options));
    }
}
