@extends('layouts.main')

@section('title', __('Gráficas BI'))

@section('content')
<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
            <h1>Gráficas BI</h1>

            @if ($error)
                <div class="alert alert-danger">
                    {{ $error }}
                </div>
            @else
                <div style="width: 600px;">
                    <canvas id="graficoLinea"></canvas>
                </div>
                <div style="width: 600px;">
                    <canvas id="graficoTorta"></canvas>
                </div>
            @endif
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
