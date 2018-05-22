<?php

namespace Conlect\ImageIIIF;

use Noodlehaus\Config;
use Intervention\Image\ImageManager;

class ImageFactory
{
    /**
     * The image driver.
     *
     * @var string
     */
    protected $driver = 'gd';


   public function __invoke(array $config = null)
   {
        if (is_null($config)) {
           $config = new Config(__DIR__ . '/../config');
        }

        $manager = $this->getImageManager($config['driver']);

        return new ImageIIIF($manager, $config);
   }


    /**
     *
     * @return ImageManager
     */
    public function getImageManager($driver = null)
    {
        if (is_null($driver)) {
            $driver = $this->driver;
        }

        return new ImageManager(
            [
                'driver' => $driver,
            ]
        );
    }

}
