<?php

namespace Conlect\ImageIIIF\Traits;

trait supportedFormats
{
    public function getSupportedFormats(string $driver)
    {
        $formats = [
            'jpg',
            'png',
            'gif',
            'webp',
        ];

        if ($driver && $driver === 'imagick') {
            $formats[] = 'jp2';
            $formats[] = 'tif';
        }

        return $formats;
    }
}
