[![Latest Version on Packagist](https://img.shields.io/packagist/v/conlect/image-iiif.svg?style=flat-square)](https://packagist.org/packages/conlect/image-iiif)
[![Tests](https://github.com/conlect/image-iiif/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/conlect/image-iiif/actions/workflows/run-tests.yml)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/conlect/image-iiif/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/conlect/image-iiif/?branch=main)
[![Total Downloads](https://img.shields.io/packagist/dt/conlect/image-iiif.svg?style=flat-square)](https://packagist.org/packages/conlect/image-iiif)

# Image IIIF

This package implements the [IIIF Image API 3.0](https://iiif.io/api/image/3.0/), it is unopinionated about implementation and many of the `MUST` features are not included because it does not include an actual implementation only the means to create one. I consider it a bring your own framework solution for implementing Image API 3.0 with PHP. The package utilizes the [Intervention Image](http://image.intervention.io/) package for manipulations. I have provided Intervention filters for each of the 5 IIIF parameters that can be used independently of the `$factory()->load()->withParameters()` pipeline methods.

**Supports all Image Request Parameters:**

-   Region (full || square || x,y,w,h || pct:x,y,w,h)
-   Size (full || max || w, || ,h || pct:n || w,h || !w,h)
-   Rotation (n || !n)
-   Quality (color || gray || default)
-   Format (jpg || tif || png || gif || webp)

Supports the `info.json` response for an identifier.

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
