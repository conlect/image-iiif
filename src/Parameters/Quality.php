<?php

namespace Conlect\ImageIIIF\Parameters;

use Conlect\ImageIIIF\Parameters\Contracts\ParameterInterface;

class Quality extends ParameterAbstract implements ParameterInterface
{
    public function apply(array $options)
    {
        $quality = $options[0];

        if ($quality === 'default') {
            $quality = config('iiif.quality_default');
        }

        if ($quality === 'gray') {
            return $this->image->greyscale();
        }

        if ($quality === 'color') {
            return $this->image;
        }

        if ($quality === 'bitonal') {
            return $this->image->encode('bmp');
        }
    }
}
