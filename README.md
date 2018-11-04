# Image IIIF

This package implements the [IIIF Image API 2.1](http://iiif.io/api/image/2.1/), it is unopinionated about implementation and many of the `MUST` features are not included because it does not include an actual implementation only the means to create one. I consider it a bring your own framework solution for implementing Image API 2.1 with PHP. The package utilizes the [Intervention Image](http://image.intervention.io/) package for manipulations. I have provided Intervention filters for each of the 5 IIIF parameters that can be used independently of the `$factory()->load()->withParameters()` pipeline methods. I have also provided Regex within config for validation of image request parameters.

**Supports all Image Request Parameters:**
- Region (full || square || x,y,w,h || pct:x,y,w,h)
- Size (full || max || w, || ,h || pct:n || w,h || !w,h)
- Rotation (n || !n)
- Quality (color || gray || default)
- Format (jpg || png || gif || webp)

Supports the `info.json` response for an identifier.

Currently only tested with 'GD' Libray. If utilizing 'Imagick' more config options may become available.


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

<br>

**Todo:**
- utilize [php-vips](https://github.com/jcupitt/php-vips) or create second libvips implemetation
- setup demo / documentation site
- Laravel and Slim demo applications
- figure out how to handle bitonal 1-bit images
- support more formats (tif, pdf)
- support optional "sizes" within info.json
