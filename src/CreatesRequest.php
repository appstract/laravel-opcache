<?php

namespace Appstract\Opcache;

use Appstract\LushHttp\LushFacade as Lush;
use Illuminate\Support\Facades\Crypt as Crypt;

trait CreatesRequest
{
    /**
     * @param $url
     *
     * @return mixed
     */
    public function sendRequest($url)
    {
        return Lush::options(['verify_ssl' => config('opcache.verify_ssl')])->get(config('opcache.url').'/opcache-api/'.$url,
            ['key' => Crypt::encrypt('opcache')]
        );
    }
}
