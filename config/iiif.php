<?php

return [

    'driver' => 'gd',

    'parameters' => [
        'region' => \Conlect\ImageIIIF\Parameter\Region::class,
        'size' => \Conlect\ImageIIIF\Parameter\Size::class,
        'rotation' => \Conlect\ImageIIIF\Parameter\Rotation::class,
        'quality' => \Conlect\ImageIIIF\Parameter\Quality::class,
        'format' => \Conlect\ImageIIIF\Parameter\Format::class,
    ],

    'supports' => [
        'baseUriRedirect', // The base URI of the service will redirect to the image information document.
        'canonicalLinkHeader', //
        'cors',
    ],

    'qualities' => [
        'color', // full color
        'gray', // grayscale
        'bitonal', // each pixel is either black or white.
        'default', // default quality
    ],

    'quality_default' => 'color',

    'formats' => [
        'jpg', // image/jpeg
        'tif', // image/tiff
        'png', // image/png
        'gif', // image/gif
        'jp2', // image/jp2
        'pdf', // application/pdf
        'webp', // image/webp
    ],
];
