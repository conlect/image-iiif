<?php

namespace Conlect\ImageIIIF;

use Noodlehaus\Config;
use Intervention\Image\ImageManager;

class ImageIIIF
{
    public $manager;

    protected $config;

    public $image;

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
            'profile' => 'level2',
            'height' => $this->image->height(),
            'width' => $this->image->width(),
            'tiles'=> [
                [
                    'width' => $this->config['tile_width'],
                    'scaleFactors' => $this->getScaleFactors(),
                ]
            ],
            'extraFormats' => $this->config['formats'],
            'extraQualities' => $this->config['qualities'],
            'extraFeatures' => $this->config['supports']
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
