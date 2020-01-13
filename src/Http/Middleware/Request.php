<?php

namespace Appstract\Opcache\Http\Middleware;

use Closure;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt as Crypt;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class Request.
 */
class Request
{
    /**
     * Handle incoming request.
     *
     * @param         $request
     * @param Closure $next
     *
     * @return mixed
     * @throws HttpException
     */
    public function handle($request, Closure $next)
    {
        if (! $this->isAllowed($request)) {
            throw new HttpException(403, 'This action is unauthorized.');
        }

        return $next($request);
    }

    /**
     * Check if the request is allowed.
     *
     * @param $request
     *
     * @return bool
     */
    protected function isAllowed($request)
    {
        try {
            $decrypted = Crypt::decrypt($request->get('key'));
        } catch (DecryptException $e) {
            $decrypted = '';
        }

        return $decrypted == 'opcache' || in_array($this->getRequestIp($request), [$this->getServerIp(), '127.0.0.1', '::1']);
    }

    /**
     * Get ip from different request headers.
     *
     * @param $request
     *
     * @return mixed
     */
    protected function getRequestIp($request)
    {
        if ($request->server('HTTP_CF_CONNECTING_IP')) {
            // cloudflare
            return $request->server('HTTP_CF_CONNECTING_IP');
        }

        if ($request->server('X_FORWARDED_FOR')) {
            // forwarded proxy
            return $request->server('X_FORWARDED_FOR');
        }

        if ($request->server('REMOTE_ADDR')) {
            // remote header
            return $request->server('REMOTE_ADDR');
        }
    }

    /**
     * Get the server ip.
     *
     * @return string
     */
    protected function getServerIp()
    {
        if (isset($_SERVER['SERVER_ADDR'])) {
            return $_SERVER['SERVER_ADDR'];
        }

        if (isset($_SERVER['LOCAL_ADDR'])) {
            return $_SERVER['LOCAL_ADDR'];
        }

        return '127.0.0.1';
    }
}
