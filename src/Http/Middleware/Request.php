<?php

namespace Appstract\Opcache\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;

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
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next)
    {
        if (! in_array($this->getRequestIp($request), [$_SERVER['SERVER_ADDR'], '127.0.0.1', '::1'])) {
            throw new AuthorizationException('This action is unauthorized.');
        }

        return $next($request);
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
}
