<?php

return [

    'base_url' => 'https://example.test',

    'driver' => 'gd', // or imagick

    'allow_upscaling' => true,

    'tile_width' => 1024,

    'quality' => 90,

    'mime' => [
        'jpg' => 'image/jpeg',
        'tif' => 'image/tiff',
        'png' => 'image/png',
        'gif' => 'image/gif',
        // 'jp2' => 'image/jp2',
        // 'pdf' => 'application/pdf',
        'webp' => 'image/webp',
    ],

    'maxArea' => null,
    'maxHeight' => null,
    'maxWidth' => null,

    'qualities' => [
        'color',
        'gray',
        // 'bitonal',
        'default',
    ],

    'supports' => [
        'baseUriRedirect',
        "jsonldMediaType",
    ],
];
