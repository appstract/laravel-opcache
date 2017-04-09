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

        // check if the source is trusted
        $requestIp = $request->server('HTTP_CF_CONNECTING_IP') ?? $request->server('REMOTE_ADDR');
        if (!in_array($requestIp, [$_SERVER['SERVER_ADDR'], '127.0.0.1', '::1'])) {
            throw new AuthorizationException('This action is unauthorized.');
        }

        return $next($request);
    }
}
