<?php

namespace Conlect\ImageIIIF\Parameters;

use Conlect\ImageIIIF\Filters\FormatFilter;
use Conlect\ImageIIIF\Parameters\Contracts\ParameterInterface;

class Format extends ParameterAbstract implements ParameterInterface
{
    public function apply($options)
    {
        return $this->image->encodeByExtension($options);
    }
}
