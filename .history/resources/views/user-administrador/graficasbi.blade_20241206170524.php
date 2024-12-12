@extends('layouts.main')
    @section('title', __('Gráficas BI'))
    @section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Gráficas BI') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Panel de Control'), ['']) !!}</li>
            <li class="breadcrumb-item">{{ __('Gráficas BI') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <h1>Gráficas BI</h1>
    <div style="width: 600px;">
        <canvas id="graficoLinea"></canvas>
    </div>
    <div style="width: 600px;">
        <canvas id="graficoTorta"></canvas>
    </div>
    @if ($errors->any())
    <div style="color: red;">
        <p>{{ $errors->first() }}</p>
    </div>
    @endif

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos para gráfico de línea
        const dataLinea = {
            labels: @json(array_keys($procesado['totales'])),
            datasets: [{
                label: 'Cantidad por Categoría',
                data: @json(array_values($procesado['totales'])),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        };

        // Configuración del gráfico de línea
        const configLinea = {
            type: 'line',
            data: dataLinea,
        };

        // Renderizar gráfico de línea
        new Chart(
            document.getElementById('graficoLinea'),
            configLinea
        );

        // Datos para gráfico de torta
        const dataTorta = {
            labels: @json(array_keys($procesado['totales'])),
            datasets: [{
                data: @json(array_values($procesado['totales'])),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
            }]
        };

        // Configuración del gráfico de torta
        const configTorta = {
            type: 'pie',
            data: dataTorta,
        };

        // Renderizar gráfico de torta
        new Chart(
            document.getElementById('graficoTorta'),
            configTorta
        );
    </script>

@endsection 