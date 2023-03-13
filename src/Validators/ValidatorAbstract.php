<?php

namespace Conlect\ImageIIIF\Validators;

abstract class ValidatorAbstract
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }
}
