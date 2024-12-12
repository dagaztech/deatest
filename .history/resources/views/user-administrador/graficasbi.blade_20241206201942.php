@extends('layouts.main')

@section('title', __('Gráficas BI'))

@section('content')
<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
            <h1>Gráficas BI</h1>


            <canvas id="myChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('script')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Las etiquetas y los datos los pasamos desde Laravel a JavaScript
    const labels = @json($labels);  // Las etiquetas del gráfico
    const data = @json($data);      // Los datos del gráfico

    // Configuración del gráfico
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',  // Tipo de gráfico (puede ser 'line', 'bar', etc.)
        data: {
            labels: labels,  // Las etiquetas
            datasets: [{
                label: 'Datos del formulario',  // Etiqueta del conjunto de datos
                data: data,                  // Los valores de los datos
                backgroundColor: 'rgba(54, 162, 235, 0.2)',  // Color de fondo de las barras
                borderColor: 'rgba(54, 162, 235, 1)',      // Color de borde de las barras
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true  // Aseguramos que el eje Y comience en 0
                }
            }
        }
    });
</script>
@endpush
