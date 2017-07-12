<?php

namespace Appstract\Opcache\Http\Middleware;

use Closure;
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
        return decrypt($request->get('key')) == 'opcache' ||
            in_array($this->getRequestIp($request), [$this->getServerIp(), '127.0.0.1', '::1']);
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
        } elseif ($request->server('X_FORWARDED_FOR')) {
            // forwarded proxy
            return $request->server('X_FORWARDED_FOR');
        } elseif ($request->server('REMOTE_ADDR')) {
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
        return isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] :
            isset($_SERVER['LOCAL_ADDR']) ? $_SERVER['LOCAL_ADDR'] : '127.0.0.1';
    }
}
