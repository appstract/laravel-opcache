<?php

namespace Appstract\Opcache;

use Illuminate\Support\Facades\Crypt as Crypt;
use Illuminate\Support\Facades\Http;

trait CreatesRequest
{
    /**
     * @param $url
     * @param $parameters
     * @return \Illuminate\Http\Client\Response
     */
    public function sendRequest($url, $parameters = [])
    {
        return Http::withHeaders(config('opcache.headers'))
            ->withOptions(['verify' => config('opcache.verify')])
            ->get($this->buildEndpoint($url),
                array_merge(['key' => Crypt::encrypt('opcache')], $parameters)
        );
    }

    /**
     * @param string $url
     * @return string
     */
    protected function buildEndpoint(string $url): string {
        return rtrim(config('opcache.url'), '/').'/'.trim(config('opcache.prefix'), '/').'/'.ltrim($url, '/');
    }
}
