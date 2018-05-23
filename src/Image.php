<?php

namespace Conlect\ImageIIIF;

use Noodlehaus\Config;
use Intervention\Image\ImageManager;

class ImageIIIF
{
    protected $manager;

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
        return $this->image->encode('png')->stream();
    }

    protected function applyParameters(array $parameters)
    {
        $availableParameters = $this->config->get('parameters');
        // dd($availableParameters);

        foreach ($parameters as $filter => $options) {
            if (!in_array($filter, array_keys($availableParameters))) {
                continue;
            }

            $this->image = (new $availableParameters[$filter]($this->image))->apply(explode(',', $options));
        }
    }
}
