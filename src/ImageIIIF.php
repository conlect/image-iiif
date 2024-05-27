<?php

namespace Conlect\ImageIIIF;

use Intervention\Image\ImageManager;
use Noodlehaus\Config;

class ImageIIIF
{
    use \Conlect\ImageIIIF\Traits\SupportedFormats;

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
        // dd($file);
        $this->image = $this->manager->read(file_get_contents($file));

        return $this;
    }

    public function withParameters(array $parameters)
    {
        $this->applyParameters($parameters);

        return $this;
    }

    public function stream()
    {
        return $this->image;
    }

    protected function applyParameters(array $parameters)
    {
        $iiifParameters = [
            'region' => \Conlect\ImageIIIF\Parameters\Region::class,
            'size' => \Conlect\ImageIIIF\Parameters\Size::class,
            'rotation' => \Conlect\ImageIIIF\Parameters\Rotation::class,
            'quality' => \Conlect\ImageIIIF\Parameters\Quality::class,
            'format' => \Conlect\ImageIIIF\Parameters\Format::class,
        ];

        foreach ($parameters as $parameter => $options) {
            if (! in_array($parameter, array_keys($iiifParameters))) {
                continue;
            }

            $this->image = (new $iiifParameters[$parameter]($this->image))->apply($options);
        }
    }

    public function hasValidParameters(array $parameters)
    {
        $validators = [
            'region' => \Conlect\ImageIIIF\Validators\RegionValidator::class,
            'size' => \Conlect\ImageIIIF\Validators\SizeValidator::class,
            'rotation' => \Conlect\ImageIIIF\Validators\RotationValidator::class,
            'quality' => \Conlect\ImageIIIF\Validators\QualityValidator::class,
            'format' => \Conlect\ImageIIIF\Validators\FormatValidator::class,
        ];

        foreach ($parameters as $parameter => $value) {
            if (! in_array($parameter, array_keys($validators))) {
                continue;
            }

            if (! (new $validators[$parameter]($this->config, $this->image))->valid($value)) {
                return false;
            }
        }

        return true;
    }

    public function info(string $prefix, string $identifier)
    {
        // TODO
        // Optional - maxWidth, maxHeight, maxArea
        // sizes - prefered w,h pairs
        // rights - CC license
        return [
            '@context' => 'http://iiif.io/api/image/3/context.json',
            'id' => $this->config['base_url'] . '/' . $prefix . '/' . $identifier,
            'type' => 'ImageService3',
            'protocol' => 'http://iiif.io/api/image',
            'profile' => 'level2',
            'height' => $this->image->height(),
            'width' => $this->image->width(),
            'tiles' => [
                [
                    'width' => $this->config['tile_width'],
                    'scaleFactors' => $this->getScaleFactors(),
                ],
            ],
            'extraFormats' => $this->getExtraFormats(),
            'extraQualities' => ['color', 'gray'],
            'extraFeatures' => $this->config['extraFeatures'],
        ];
    }

    protected function getScaleFactors()
    {
        $scaleFactors = [];
        $maxSize = max($this->image->width(), $this->image->height());
        $total = (int) ceil($maxSize / $this->config['tile_width']);
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

    protected function getExtraFormats()
    {
        $formats = $this->getSupportedFormats((string) $this->config['driver']);

        // All formats except level2 deafults of jpg and png
        return array_intersect($formats, ['jpg', 'png']);
    }
}
