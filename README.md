**THIS PACKAGE IS STILL IN DEVELOPMENT**

# Image IIIF

Package implements the [IIIF Image API 2.1](http://iiif.io/api/image/2.1/).  The package is unopinionated about implementation and many `MUST` features are not included. It is a bring your own framework solution for PHP. Regex is provided within the config for validation of image request parameters.

Supports all Image Request Parameters:
- Region (full || square || x,y,w,h || pct:x,y,w,h)
- Size (full || max || w, || ,h || pct:n || w,h || !w,h)
- Rotation (n || !n)
- Quality (color || gray || default)
- Format (jpg || png || gif || webp)

Supports the `info.json` response for  a indentifier.

Currently only tested with 'GD' Libray. If utilizing 'Imagick' more config options may become available.

Todo:
- support more formats (tif, pdf)
- figure out how to handle bitonal 1-bit images
- utilize [php-vips](https://github.com/jcupitt/php-vips)
- setup demo / documentation site
- Laravel and Slim demo applications


#### Laravel image route example:

```php
Route::get('iiif/{identifier}/{region}/{size}/{rotation}/{quality}.{format}',
    function (Request $request) {
        $parameters = $request->route()->parameters();

        $file = storage_path('app/images/'.$parameters['identifier']);

        $factory = new \Conlect\ImageIIIF\ImageFactory;

        $file = $factory()->load($file)
            ->withParameters($parameters)
            ->stream();

        $response = \Response::make($file);

        $response->header('Content-Type', config("iiif.mime.{$parameters['format']}"));

        return $response;
    }
);

```

#### Laravel info route example:

```php
Route::get('iiif/{identifier}/info.json',
    function (Request $request) {
        $file = storage_path('app/images/'.$request->identifier);

        $factory = new \Conlect\ImageIIIF\ImageFactory;

        $info = $factory()->load($file)
            ->info($request->identifier);

        return $info;
    }
);
```
