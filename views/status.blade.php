@extends('opcache::default')
@section('title', trans('opcache::messages.status.title'))

@section('content')
<section id="status-tabs" class="tabs">
    <div class="data-block clear">
        <h2>{{ trans('opcache::messages.status.title') }}</h2>
        <table>
            @foreach ($status->getStatusInfo() as $key => $statusItem)
                <tr>
                    <td>{{ trans('opcache::messages.status.' . $key) }}</td>
                    @if ($key === 'opcache_enabled')
                        <td><span class="{{ $statusItem ? 'g' : 'r' }}s"></span></td>
                    @else
                        <td><span class="{{ $statusItem ? 'r' : 'g' }}s"></span></td>
                    @endif
                </tr>
            @endforeach
        </table>
        <form action="{{ route('opcache-api.reset') }}" method="post" id="reset" data-confirmation="{{ trans('opcache::messages.confirmation.reset') }}" data-yes="{{ trans('opcache::messages.confirmation.yes') }}" data-no="{{ trans('opcache::messages.confirmation.no') }}">
            <input type="hidden" name="key" value="{{ \Crypt::encrypt('opcache') }}">
            <button type="submit" name="submit" value="Reset" class="cnfbtn cnfbtn--fn js-confirm reset-btn">{{ trans('opcache::messages.reset.submit') }}</button>
        </form>
    </div>

    <div class="data-block">
        <h2>{{ trans('opcache::messages.memory.title') }}</h2>
        <table>
            @foreach ($status->getMemoryInfo() as $key => $memoryItem)
                <tr>
                    <td>{{ trans('opcache::messages.memory.' . $key) }}</td>
                    <td>{{ $memoryItem }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="data-block">
        <h2>{{ trans('opcache::messages.stats.title') }}</h2>
        @foreach ($status->getStatsInfo() as $statisticList)
            <div>
                <table>
                    @foreach ($statisticList as $key => $statisticItem)
                        <tr>
                            <td>{{ trans('opcache::messages.stats.' . $key) }}</td>
                            <td>{{ $statisticItem }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endforeach
    </div>
</section>
@stop
