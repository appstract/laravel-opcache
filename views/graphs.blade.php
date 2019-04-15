@extends('opcache::default')
@section('title', trans('opcache::messages.graph.title'))

@section('content')
<section id="graphs" class="tabs">
    <ul>
        <li>
            <div class="chart-wrapper">
                <h2>{{ trans('opcache::messages.graph.memory.title') }}</h2>
                <canvas id="memory" width="230" height="230"></canvas>
                <div id="memDataChartLegend"></div>
            </div>
        </li>
        <li>
            <div class="chart-wrapper">
                <h2>{{ trans('opcache::messages.graph.keys.title') }}</h2>
                <canvas id="keys" width="230" height="230"></canvas>
                <div id="keysDataChartLegend"></div>
            </div>
        </li>
        <li>
            <div class="chart-wrapper">
                <h2>{{ trans('opcache::messages.graph.hits.title') }}</h2>
                <canvas id="hits" width="230" height="230"></canvas>
                <div id="hitsDataChartLegend"></div>
            </div>
        </li>
    </ul>
</section>

@push('children')
<script>
    var memData  = {!! $status->getGraphMemoryInfo() !!};
    var keysData = {!! $status->getGraphKeyStatsInfo() !!};
    var hitsData = {!! $status->getGraphHitStatsInfo() !!};
</script>
@endpush
@stop
