<?php

namespace Conlect\ImageIIIF\Parameters;

use Conlect\ImageIIIF\Parameters\Contracts\ParameterInterface;

class Rotation extends ParameterAbstract implements ParameterInterface
{
    public function apply(array $options)
    {
        $mirror = strpos($options[0], '!') === false ? false : true;
        $rotation = $mirror ? substr($options[0], 1) : $options[0];
        if ($mirror) {
            $this->image->flip('h');
        }
        return $this->image->rotate(-$rotation);
    }
}
