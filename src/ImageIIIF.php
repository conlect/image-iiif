<?php

namespace Conlect\ImageIIIF;

use Noodlehaus\Config;
use Intervention\Image\ImageManager;

class ImageIIIF
{
    public $manager;

    protected $config;

    protected $image;

    public function __construct(ImageManager $manager, Config $config = null)
    {
        $this->manager = $manager;
        $this->config = $config;
    }

    public function load($file)
    {
        $this->image = $this->manager->make($file);

        return $this;
    }

    public function withParameters(array $parameters)
    {
        $this->applyParameters($parameters);

        return $this;
    }

    public function stream()
    {
        return $this->image->stream();
    }

    protected function applyParameters(array $parameters)
    {
        $availableParameters = $this->config->get('parameters');

        foreach ($parameters as $parameter => $options) {
            if (!in_array($parameter, array_keys($availableParameters))) {
                continue;
            }

            $this->image = (new $availableParameters[$parameter]($this->image))->apply($options);
        }
    }

    public function info($identifier)
    {
        return [
            '@context' => 'http://iiif.io/api/image/2/context.json',
            'id' => $this->config['base_url'] . '/' . $this->config['prefix'] . '/' . $identifier,
            'type' => 'ImageService3',
            'protocol' => 'http://iiif.io/api/image',
            'height' => $this->image->height(),
            'width' => $this->image->width(),
            'profile' => [
                'http://iiif.io/api/image/2/level2.json', [
                    'supports' => $this->config['supports'],
                    'qualities' => $this->config['qualities'],
                    'formats' => $this->config['formats']
                ]
            ],
            'tiles'=> [
                [
                    'width' => $this->config['tile_width'],
                    'scaleFactors' => $this->getScaleFactors(),
                ]
            ],
        ];
    }

    protected function getScaleFactors()
    {
        $scaleFactors = [];
        $maxSize = max($this->image->width(), $this->image->height());
        $total = (integer) ceil($maxSize / $this->config->get('tile_width'));
        $factor = 1;
        while ($factor / 2 <= $total) {
            $scaleFactors[] = $factor;
            $factor = $factor * 2;
        }
        if (count($scaleFactors) <= 1) {
            return;
        }
        return $scaleFactors;
    }
}
