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
        if (! $request->server('REMOTE_ADDR') == $_SERVER['SERVER_ADDR']) {
            throw new AuthorizationException('This action is unauthorized.');
        }

        return $next($request);
    }
}
