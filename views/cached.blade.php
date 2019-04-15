@extends('opcache::default')
@section('title', trans('opcache::messages.scripts.title'))

@section('content')
<section id="cached-scripts-tabs" class="tabs">
    <nav id="sub-nav">
        <ul>
            <li class="sna">
                <a href="#" data-tab="cached-scripts">
                    {{ trans('opcache::messages.scripts.title') }}
                </a>
            </li>
            <li>
                <a href="#" data-tab="overview-scripts">
                    {{ trans('opcache::messages.scripts.overview.title') }}
                </a>
            </li>
        </ul>
    </nav>
    <section data-content="cached-scripts">
        @if (!count($directories))
            <br />
            <p>{{ trans('opcache::messages.scripts.empty') }}</p>
        @else
            <table>
                @foreach($directories as $directory => $scripts)
                    <tr>
                        <td>
                            <p><a href="#"><span class="fa fa-plus"></span>{!! htmlspecialchars($directory) . sprintf(trans('opcache::messages.scripts.directory.script_count'), count($scripts)) !!}</a></p>
                            <div class="cs-data-table">
                                <table>
                                    <thead>
                                    <tr>
                                        <th>{{ trans('opcache::messages.scripts.full_path') }}</th>
                                        <th>{{ trans('opcache::messages.scripts.hits') }}</th>
                                        <th>{{ trans('opcache::messages.scripts.memory_consumption') }}</th>
                                        <th>{{ trans('opcache::messages.scripts.last_used_timestamp') }}</th>
                                        <th>{{ trans('opcache::messages.scripts.timestamp') }}</th>
                                        <th>{{ trans('opcache::messages.scripts.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($scripts as $filename => $script)
                                        <tr>
                                            <td>{{ htmlspecialchars($filename) }}</td>
                                            <td>{{ $script['hits'] }}</td>
                                            <td>{{ $script['memory_consumption'] }}</td>
                                            <td>{{ $script['last_used_timestamp'] }}</td>
                                            <td>{{ $script['timestamp'] }}</td>
                                            <td>
                                                <form action="{{ route('opcache-api.invalidate') }}" method="post">
                                                    <input type="hidden" name="key" value="{{ \Crypt::encrypt('opcache') }}">
                                                    <input type="hidden" name="full_path" value="{{ $script['full_path'] }}">
                                                    <button type="submit" name="submit" value="Invalidate" class="cnfbtn cnfbtn--fn js-confirm inv" title="{{ trans('opcache::messages.scripts.invalidate') }}">{{ trans('opcache::messages.scripts.invalidate') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </section>
    <section data-content="overview-scripts">
        <div class="show-cs-table cs-table-overview">
            <input type="search" name="filter" placeholder="{{ trans('opcache::messages.scripts.filter.placeholder') }}" autofocus>
            <table>
                <thead>
                <tr>
                    <th>{{ trans('opcache::messages.scripts.full_path') }}</th>
                    <th>{{ trans('opcache::messages.scripts.hits') }}</th>
                    <th>{{ trans('opcache::messages.scripts.memory_consumption') }}</th>
                    <th>{{ trans('opcache::messages.scripts.last_used_timestamp') }}</th>
                    <th>{{ trans('opcache::messages.scripts.actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cachedScriptsForOverview as $script)
                    <tr>
                        <td>{{ htmlspecialchars($script['full_path']) }}</td>
                        <td>{{ $script['hits'] }}</td>
                        <td>{{ $script['memory_consumption'] }}</td>
                        <td>{{ $script['last_used_timestamp'] }}</td>
                        <td>
                            <form action="{{ route('opcache-api.invalidate') }}" method="post">
                                <input type="hidden" name="key" value="{{ \Crypt::encrypt('opcache') }}">
                                <input type="hidden" name="full_path" value="{{ $script['prefix'] . $script['full_path'] }}">
                                <button type="submit" name="submit" value="Invalidate" class="cnfbtn cnfbtn--fn js-confirm inv" title="{{ trans('opcache::messages.script.invalidate') }}">{{ trans('opcache::messages.script.invalidate') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
</section>
@stop
