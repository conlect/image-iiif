<?php

namespace Conlect\ImageIIIF\Validators;

abstract class ValidatorAbstract
{
    public function __construct($config)
    {
        $this->config = $config;
    }
}
