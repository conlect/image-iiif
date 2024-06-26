<?php

namespace Conlect\ImageIIIF;

use Intervention\Image\ImageManager;
use Noodlehaus\Config;
use Noodlehaus\Parser\Json;

class ImageFactory
{
    /**
     * The image driver.
     *
     * @var string
     */
    protected string $driver = 'gd';

    protected array $config;

    public function __invoke(array $config = null)
    {
        if (is_null($config)) {
            $config = new Config(__DIR__ . '/../config');
        } else {
            $config = new Config(json_encode($config), new Json(), true);
        }

        $manager = $this->getImageManager($config['driver']);

        return new ImageIIIF($manager, $config);
    }

    /**
     *
     * @return ImageManager
     */
    public function getImageManager(string $driver = null)
    {
        if (is_null($driver)) {
            $driver = $this->driver;
        }

        return match ($driver) {
            'gd' => ImageManager::gd(),
            'imagick' => ImageManager::imagick(),
        };
    }
}
