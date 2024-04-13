<?php

namespace Conlect\ImageIIIF\Filters;

use Intervention\Image\Image;

interface FilterInterface
{
    public function applyFilter(Image $image);
}
