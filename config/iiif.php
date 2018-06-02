<?php

return [

    'driver' => 'gd', //'imagick',

    'base_url' => 'http://packages.test',

    'prefix' => 'iiif',

    'tile_width' => 1024,

    'parameters' => [
        'region' => \Conlect\ImageIIIF\Parameters\Region::class,
        'size' => \Conlect\ImageIIIF\Parameters\Size::class,
        'rotation' => \Conlect\ImageIIIF\Parameters\Rotation::class,
        'quality' => \Conlect\ImageIIIF\Parameters\Quality::class,
        'format' => \Conlect\ImageIIIF\Parameters\Format::class,
    ],

    // percent allow upsize - pct:[0-9]+\.?\d{0,10}
    // percent max 99.9999999999 - pct:(\d{0,2})(\.\d{1,10})?

    'regex' => [
        'region' => 'full|square|[0-9]+,[0-9]+,[0-9]+,[0-9]+|pct:(\d{0,2})(\.\d{1,10})?,(\d{0,2})(\.\d{1,10})?,(\d{0,2})(\.\d{1,10})?,(\d{0,2})(\.\d{1,10})?',
        'size' => 'full|max|[0-9]+,|,[0-9]+|pct:(\d{0,2})(\.\d{1,10})?|[0-9]+,[0-9]+|![0-9]+,[0-9]+',
        'rotation' => '![0-9]+\.?\d{0,10}|[0-9]+\.?\d{0,10}',
    ],

    'formats' => [
        'jpg', // image/jpeg
        // 'tif', // image/tiff
        'png', // image/png
        'gif', // image/gif
        // 'jp2', // image/jp2
        // 'pdf', // application/pdf
        'webp', // image/webp
    ],

    'mime' => [
        'jpg' => 'image/jpeg',
        'tif' => 'image/tiff',
        'png' => 'image/png',
        'gif' => 'image/gif',
        'jp2' => 'image/jp2',
        'pdf' => 'application/pdf',
        'webp' => 'image/webp',
    ],

    'maxArea' => null,
    'maxHeight' => null,
    'maxWidth' => null,

    'qualities' => [
        'color', // full color
        'gray', // grayscale
        // 'bitonal', // each pixel is either black or white. (imagick only)
        'default', // default quality
    ],

    'quality_default' => 'color',

    'supports' => [
        'baseUriRedirect', // The base URI of the service will redirect to the image information document.
        'canonicalLinkHeader', //
        'cors',
    ],


];
