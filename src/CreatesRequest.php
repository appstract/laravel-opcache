<?php

namespace Appstract\Opcache;

use Crypt;
use Appstract\LushHttp\LushFacade as Lush;

trait CreatesRequest
{
    /**
     * @param $url
     *
     * @return mixed
     */
    public function sendRequest($url)
    {
        return Lush::get(config('opcache.url').'/opcache-api/'.$url, ['key' => Crypt::encrypt('opcache')]);
    }
}
