<!DOCTYPE html>
<html lang="<?php echo config('app.locale') ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>@yield('title') - PHP OpCache Status</title>
    <link rel="stylesheet" href="{{ asset('packages/appstract/opcache/css/main.css') }}">
    <link rel="shortcut icon" href="{{ asset('packages/appstract/opcache/favicon.ico') }}" type="image/x-icon">
</head>
<body>
    <header>
        <nav class="clear">
            <ul>
                <li id="logo">
                    <a href="#">Op<span>Cache</span>
                        <sup>{{ htmlspecialchars(\Appstract\Opcache\OpcacheFacade::getConfig()['version']['version']) }}</sup>
                    </a>
                </li>
                <li>@yield('title')</li>
                <li>
                    <a href="https://github.com/appstract/laravel-opcache" target="_blank">
                        <span class="fa fa-github"></span>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <section id="main-wrap">
        <aside>
            <nav class="clear">
                <ul>
                    <li class="{{ \Appstract\Opcache\Helpers::active('panel.status') }}">
                        <a href="{{ route('panel.status') }}"><span class="fa fa-dashboard"></span>{{ trans('opcache::messages.menu.status') }}</a>
                    </li>
                    <li class="{{ \Appstract\Opcache\Helpers::active('panel.config') }}">
                        <a href="{{ route('panel.config') }}"><span class="fa fa-wrench"></span>{{ trans('opcache::messages.menu.config') }}</a>
                    </li>
                    <li class="{{ \Appstract\Opcache\Helpers::active('panel.cached-scripts') }}">
                        <a href="{{ route('panel.cached-scripts') }}"><span class="fa fa-file-text-o"></span>{{ trans('opcache::messages.menu.scripts') }}</a>
                    </li>
                    <li class="{{ \Appstract\Opcache\Helpers::active('panel.graphs') }}">
                        <a href="{{ route('panel.graphs') }}"><span class="fa fa-pie-chart"></span>{{ trans('opcache::messages.menu.graphs') }}</a>
                    </li>
                </ul>
            </nav>
        </aside>
        <section id="content">
            @yield('content', '')
        </section>
    </section>
    @stack('children')
    <script src="{{ asset('packages/appstract/opcache/js/main.js') }}"></script>
</body>
</html>
