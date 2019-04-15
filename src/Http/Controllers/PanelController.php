<?php

namespace Appstract\Opcache\Http\Controllers;

use Appstract\Opcache\Format\Byte as ByteFormatter;
use Appstract\Opcache\OpcacheConfiguration;
use Appstract\Opcache\OpcacheFacade as OPcache;
use Appstract\Opcache\OpcacheStatus;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class PanelController
 */
class PanelController extends BaseController
{
    /**
     * Show status info.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function status()
    {
        $status = new OpcacheStatus(
            new ByteFormatter,
            OPcache::getStatus(true)
        );

        return view('opcache::status', [
            'status' => $status,
        ]);
    }

    /**
     * Configuration.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function configuration()
    {
        $config = new OpcacheConfiguration(
            new ByteFormatter,
            OPcache::getConfig()
        );

        return view('opcache::configuration', [
            'config' => $config
        ]);
    }

    /**
     * Show opcache scripts status.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function cached()
    {
        $status = new OpcacheStatus(
            new ByteFormatter,
            OPcache::getStatus(true)
        );

        $directories = [];
        foreach ($status->getCachedScripts() as $script) {
            foreach ((array)config('opcache.directories') as $directory) {
                if (strpos($script['full_path'], $directory) !== false) {
                    $directories[dirname($script['full_path'])][basename($script['full_path'])] = $script;
                }
            }
        }

        $cachedScriptsForOverview = $status->getCachedScriptsForOverview(new \Appstract\Opcache\Format\Prefix);

        return view('opcache::cached', [
            'directories'              => $directories,
            'cachedScriptsForOverview' => $cachedScriptsForOverview,
        ]);
    }

    /**
     * Graphs.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function graphs()
    {
        $status = new OpcacheStatus(
            new ByteFormatter(),
            OPcache::getStatus(true)
        );

        return view('opcache::graphs', [
            'status' => $status
        ]);
    }
    
    /**
     * Invalidates a cached script
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function invalidate(Request $request)
    {
        $result = opcache_invalidate($request->full_path, true) ? 'success' : 'fail';

        return response()->json([
            'result' => $result,
        ]);
    }

    /**
     * Optimize.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function optimize(Request $request)
    {
        if ($request->full_path) {
            $result = @opcache_compile_file($request->full_path) ? 'success' : 'fail';
        } else {
            $result = OPcache::optimize() ? 'success' : 'fail';
        }

        return response()->json([
            'result' => $result,
        ]);
    }

    /**
     * Resets the contents of the opcode cache
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset()
    {
        $result = opcache_reset() ? 'success' : 'fail';

        return response()->json([
            'result' => $result,
        ]);
    }
}
