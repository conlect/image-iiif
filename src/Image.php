<?php

namespace Conlect\ImageIIIF;

use Noodlehaus\Config;
use Intervention\Image\ImageCache;
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
}
