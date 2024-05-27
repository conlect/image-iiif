<?php

return [
    'base_url' => 'http://localhost',

    'driver' => 'gd', // or imagick

    'tile_width' => 1024,

    'quality' => 90,

    // 'maxArea' => null,
    // 'maxHeight' => null,
    // 'maxWidth' => null,

    'supports' => [
        'mirroring',
        'rotationArbitrary',
    ],
];
