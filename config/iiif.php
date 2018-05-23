<?php

return [

    'driver' => 'gd', //'imagick',

    'parameters' => [
        'region' => \Conlect\ImageIIIF\Parameters\Region::class,
        'size' => \Conlect\ImageIIIF\Parameters\Size::class,
        'rotation' => \Conlect\ImageIIIF\Parameters\Rotation::class,
        'quality' => \Conlect\ImageIIIF\Parameters\Quality::class,
        'format' => \Conlect\ImageIIIF\Parameters\Format::class,
    ],

    'formats' => [
        'jpg', // image/jpeg
        // 'tif', // image/tiff
        'png', // image/png
        'gif', // image/gif
        // 'jp2', // image/jp2
        'pdf', // application/pdf
        'webp', // image/webp
    ],

    'maxArea' => null,
    'maxHeight' => null,
    'maxWidth' => null,

    'qualities' => [
        'color', // full color
        'gray', // grayscale
        'bitonal', // each pixel is either black or white.
        'default', // default quality
    ],

    'quality_default' => 'color',

    'supports' => [
        'baseUriRedirect', // The base URI of the service will redirect to the image information document.
        'canonicalLinkHeader', //
        'cors',
    ],


];
