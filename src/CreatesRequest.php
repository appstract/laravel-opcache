<?php

namespace Appstract\Opcache;

use Appstract\LushHttp\LushFacade as Lush;
use Illuminate\Support\Facades\Crypt as Crypt;

trait CreatesRequest
{
    /**
     * @param $url
     *
     * @return \Appstract\LushHttp\Response\LushResponse
     */
    public function sendRequest($url)
    {
        return Lush::headers(config('opcache.headers'))
            ->options(['verify_ssl' => config('opcache.verify_ssl')])
            ->get(config('opcache.url') . '/' . config('opcache.prefix') . '/' . $url,
            ['key' => Crypt::encrypt('opcache')]
        );
    }
}
