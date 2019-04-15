@extends('opcache::default')
@section('title', trans('opcache::messages.config.title'))

@section('content')
<section id="configuration-tabs" class="tabs">
    <nav id="sub-nav">
        <ul>
            <li class="sna"><a href="#" data-tab="configuration">{{ trans('opcache::messages.config.title') }}</a></li>
            <li><a href="#" data-tab="blacklist">{{ trans('opcache::messages.blacklist.title') }}</a></li>
        </ul>
    </nav>
    <section data-content="configuration">
        <table>
            @foreach ($config->getIniDirectives() as $key => $directiveItem)
                <tr>
                    <td>{{ trans('opcache::messages.config.' . $key) }}</td>
                    @if (in_array($key, [
                        'opcache.enable',
                        'opcache.enable_cli',
                        'opcache.use_cwd',
                        'opcache.validate_timestamps',
                        'opcache.dups_fix',
                        'opcache.revalidate_path',
                        'opcache.save_comments',
                        'opcache.fast_shutdown',
                        'opcache.enable_file_override',
                        'opcache.file_cache_only',
                        'opcache.file_cache_consistency_checks',
                        'opcache.file_cache_fallback',
                        'opcache.validate_permission',
                        'opcache.validate_root'
                    ]))
                        <td><span class="{{ $directiveItem ? 'gs' : 'rs' }}"></span></td>
                    @else
                        <td>{{ htmlspecialchars($directiveItem) }}</td>
                    @endif
                    <td>
                        <p>{{ trans("opcache::messages.config.$key.description") }}</p>
                    </td>
                </tr>
            @endforeach
        </table>
    </section>
    <section data-content="blacklist">
        @if (!count($config->getBlackList()))
            <br/>
            <p>{{ trans('opcache::messages.blacklist.empty') }}</p>
        @else
            <table>
                @foreach ($config->getBlackList() as $key => $blacklistedItem)
                    <tr>
                        <td>{{ htmlspecialchars($blacklistedItem) }}</td>
                    </tr>
                @endforeach
            </table>
        @endif
    </section>
</section>
@stop
