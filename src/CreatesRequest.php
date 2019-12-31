<?php

namespace Appstract\Opcache;

use Appstract\LushHttp\LushFacade as Lush;
use Illuminate\Support\Facades\Crypt as Crypt;

trait CreatesRequest
{
    /**
     * @param $url
     * @param $parameters
     * @return \Appstract\LushHttp\Response\LushResponse
     */
    public function sendRequest($url, $parameters = [])
    {
        return Lush::headers(config('opcache.headers'))
            ->options(['verify_ssl' => config('opcache.verify_ssl'),'verify_host' => config('opcache.verify_host',2)])
            ->get(config('opcache.url').'/'. config('opcache.prefix') . '/'.$url,
            array_merge(['key' => Crypt::encrypt('opcache')], $parameters)
        );
    }
}
