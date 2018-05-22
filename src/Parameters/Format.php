<?php

namespace Conlect\ImageIIIF\Parameters;

use Conlect\ImageIIIF\Parameters\Contracts\ParameterInterface;

class Format extends ParameterAbstract implements ParameterInterface
{
    public function apply(array $options)
    {
        return $this->image->encode($options[0]);
    }
}
