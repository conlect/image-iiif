<?php

return [

    'driver' => 'gd', // or imagick

    'tile_width' => 1024,

    'quality' => 90,

    'mime' => [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'tif' => 'image/tiff',
        'tiff' => 'image/tiff',
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
        'color',
        'gray',
        'bitonal',
        'default',
    ],

    'supports' => [
        'baseUriRedirect', // The base URI of the service will redirect to the image information document.
        'canonicalLinkHeader', //
        'cors',
    ],
];
