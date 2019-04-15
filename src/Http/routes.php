<?php

/**
 * @var \Illuminate\Routing\Router $router
 */

use Appstract\Opcache\Helpers;

$router->group([
    'middleware'    => [\Appstract\Opcache\Http\Middleware\Request::class],
    'prefix'        => 'opcache-api',
], function ($router) {
    $router->get('clear', 'OpcacheController@clear');
    $router->get('config', 'OpcacheController@config');
    $router->get('status', 'OpcacheController@status');
    $router->get('optimize', 'OpcacheController@optimize');

    if (! Helpers::isLumen()) {
        $router->post('invalidate', 'PanelController@invalidate')->name('opcache-api.invalidate');
        $router->post('reset', 'PanelController@reset')->name('opcache-api.reset');
        $router->post('optimize', 'PanelController@optimize')->name('opcache-api.optimize');
    }
});

if (! Helpers::isLumen()) {
    $router->group([
        'middleware'    => config('opcache.panel_middleware', []),
        'prefix'        => 'panel',
    ], function ($router) {
        $router->get('cached-scripts', 'PanelController@cached')->name('panel.cached-scripts');
        $router->get('status', 'PanelController@status')->name('panel.status');
        $router->get('graphs', 'PanelController@graphs')->name('panel.graphs');
        $router->get('config', 'PanelController@configuration')->name('panel.config');
    });
}
