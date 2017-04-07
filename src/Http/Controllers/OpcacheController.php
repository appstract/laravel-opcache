<?php

namespace Appstract\Opcache\Http\Controllers;

use Appstract\Opcache\OpcacheFacade as OPcache;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class OpcacheController.
 */
class OpcacheController extends BaseController
{
    /**
     * Clear the OPcache.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clear()
    {
        return response()->json(['result' => OPcache::clear()]);
    }

    /**
     * Get config values.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function config()
    {
        return response()->json(['result' => OPcache::getConfig()]);
    }

    /**
     * Get status info.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function status()
    {
        return response()->json(['result' => OPcache::getStatus()]);
    }

    /**
     * Optimize.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function optimize()
    {
        return response()->json(['result' => OPcache::optimize()]);
    }
}
