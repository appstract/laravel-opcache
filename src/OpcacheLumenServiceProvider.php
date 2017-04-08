<?php

namespace Appstract\Opcache;

class OpcacheLumenServiceProvider extends OpcacheServiceProvider
{
    protected function isLumen()
    {
        return true;
    }
}
