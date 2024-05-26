<?php

namespace Conlect\ImageIIIF\Traits;

trait supportedFormats
{
    function getSupportedFormats(string $driver)
    {
        $formats = [
            'jpg',
            'png',
            'gif',
            'webp',
        ];

        if ($driver === 'imagick') {
            $formats[] = 'jp2';
            $formats[] = 'tif';
        }

        return $formats;
    }
}
