<?php

namespace Conlect\ImageIIIF\Filters;

use Conlect\ImageIIIF\Exceptions\BadRequestException;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ModifierInterface;

class SizeFilter implements ModifierInterface
{
    private $options;

    /**
     * Creates new instance of filter
     *
     */
    public function __construct($options)
    {
        $this->options = explode(',', $options);
    }

    /**
     * Applies filter effects to given image
     *
     * @param  ImageInterface $image
     *
     * @return  ImageInterface $image
     */
    public function apply(ImageInterface $image): ImageInterface
    {
        if (in_array($this->options[0], ['max'])) {
            return $image;
        }

        if (strpos($this->options[0], 'pct:') !== false) {
            $percent = substr($this->options[0], 4);
            $width = $image->width() * $percent / 100;
            $height = $image->height() * $percent / 100;

            return $image->resize($width, $height);
        }

        $constrainAspectRatio = strpos($this->options[0], '!') !== false ? true : false;

        $width = $constrainAspectRatio ? substr($this->options[0], 1) : $this->options[0];
        $width = $width === '' ? null : intval($width);
        $height = isset($this->options[1]) && $this->options[1] !== '' ? intval($this->options[1]) : null;

        $this->checkSize($image->width(), $image->height(), $width, $height);
        $this->checkWidth($image->width(), $width);
        $this->checkHeight($image->height(), $height);

        if ($constrainAspectRatio) {
            return $image->scale($width, $height);
        }

        if ($width === null) {
            return $image->scale(height: $height);
        }

        if ($height === null) {
            return $image->scale(width: $width);
        }

        return $image->resize($width, $height);
    }

    protected function checkWidth($imageWidth, $width)
    {
        if ($width > $imageWidth) {
            throw new BadRequestException("Size $width, is greater than image width $imageWidth.");
        }
    }

    protected function checkHeight($imageHeight, $height)
    {
        if ($height > $imageHeight) {
            throw new BadRequestException("Size ,$height is greater than image height $imageHeight.");
        }
    }

    protected function checkSize($imageWidth, $imageHeight, $width, $height)
    {
        if ($width > $imageWidth || $height > $imageHeight) {
            throw new BadRequestException("Size $width,$height are greater than image dimensions $imageWidth x $imageHeight");
        }
    }
}
