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

<!--script>
    // Datos enviados desde el servidor
    const datos = @ json($datos);

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
</!script-->
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
