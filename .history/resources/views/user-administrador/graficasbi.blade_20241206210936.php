@extends('layouts.main')

@section('title', __('Gráficas BI'))

@section('content')
<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
           


            <h1>Gráficas para cada Form ID</h1>
    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        @foreach($charts as $chart)
            <div style="width: 30%; margin-bottom: 20px;">
                <h3>Form ID: {{ $chart['form_id'] }}</h3>
                <canvas id="chart-{{ $chart['form_id'] }}"></canvas>
                <script>
                    const ctx{{ $chart['form_id'] }} = document.getElementById('chart-{{ $chart['form_id'] }}').getContext('2d');
                    new Chart(ctx{{ $chart['form_id'] }}, {
                        type: '{{ $chart['type'] }}', // Tipo de gráfico
                        data: {
                            labels: {!! json_encode($chart['labels']) !!},
                            datasets: [{
                                label: 'Valores de Form ID {{ $chart['form_id'] }}',
                                data: {!! json_encode($chart['data']) !!},
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        }
                    });
                </script>
            </div>
        @endforeach
    </div>
        </div>
    </div>
</div>
@endsection

@push('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if (!$error)
<script>
    // Datos enviados desde el servidor
    const datos = @json($datos);

    // Configurar gráfico de líneas
    const graficoLinea = new Chart(document.getElementById('graficoLinea'), {
        type: 'line',
        data: {
            labels: Object.keys(datos.totales),
            datasets: [{
                label: 'Cantidad por Categoría',
                data: Object.values(datos.totales),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        }
    });

    // Configurar gráfico de torta
    const graficoTorta = new Chart(document.getElementById('graficoTorta'), {
        type: 'pie',
        data: {
            labels: Object.keys(datos.totales),
            datasets: [{
                data: Object.values(datos.totales),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
            }]
        }
    });
</script>
@endif
@endpush
