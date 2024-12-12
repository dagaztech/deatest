@extends('layouts.main')
@section('title', __('Reportes Descargables'))

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
@push('script')
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

@endpush