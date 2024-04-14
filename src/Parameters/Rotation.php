<?php

namespace Conlect\ImageIIIF\Parameters;

use Conlect\ImageIIIF\Filters\RotationFilter;
use Conlect\ImageIIIF\Parameters\Contracts\ParameterInterface;

class Rotation extends ParameterAbstract implements ParameterInterface
{
    public function apply($options)
    {
        return $this->image->modify(new RotationFilter($options));
    }
}
