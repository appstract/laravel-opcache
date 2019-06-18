<?php

namespace Appstract\Opcache;

use Appstract\LushHttp\LushFacade as Lush;
use Illuminate\Support\Facades\Crypt as Crypt;

trait CreatesRequest
{
    /**
     * @param $url
     * @param $parameters
     * @return mixed
     */
    public function sendRequest($url, $parameters = [])
    {
        return Lush::headers(config('opcache.headers'))
            ->options(['verify_ssl' => config('opcache.verify_ssl')])
            ->get(config('opcache.url').'/opcache-api/'.$url,
            array_merge(['key' => Crypt::encrypt('opcache')], $parameters)
        );
    }
}
