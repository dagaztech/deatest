@extends('layouts.main')

@section('title', __('Gráficas BI'))

@section('content')
<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
            <h1>Gráficas BI</h1>

            <div id="alertaError" class="alert alert-danger d-none">
                <span id="mensajeError"></span>
            </div>

            <div style="width: 600px;">
                <canvas id="graficoLinea"></canvas>
            </div>
            <div style="width: 600px;">
                <canvas id="graficoTorta"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuración inicial de los gráficos (vacíos)
    const graficoLinea = new Chart(document.getElementById('graficoLinea'), {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Cantidad por Categoría',
                data: [],
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        }
    });

    const graficoTorta = new Chart(document.getElementById('graficoTorta'), {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
            }]
        }
    });

    // Función para cargar datos desde el servidor
    function cargarDatos() {
        fetch('{{ route('api.graficasbi.datos') }}')
            .then(response => {
                if (!response.ok) {
                    throw new Error('No se pudieron cargar los datos.');
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    mostrarError(data.error);
                } else {
                    actualizarGraficos(data);
                }
            })
            .catch(error => {
                mostrarError(error.message);
            });
    }

    // Función para actualizar los gráficos con los datos recibidos
    function actualizarGraficos(data) {
        // Actualizar gráfico de línea
        graficoLinea.data.labels = Object.keys(data.totales);
        graficoLinea.data.datasets[0].data = Object.values(data.totales);
        graficoLinea.update();

        // Actualizar gráfico de torta
        graficoTorta.data.labels = Object.keys(data.totales);
        graficoTorta.data.datasets[0].data = Object.values(data.totales);
        graficoTorta.update();
    }

    // Función para mostrar errores en la vista
    function mostrarError(mensaje) {
        const alertaError = document.getElementById('alertaError');
        const mensajeError = document.getElementById('mensajeError');
        mensajeError.textContent = mensaje;
        alertaError.classList.remove('d-none');
    }

    // Cargar los datos cuando se carga la página
    document.addEventListener('DOMContentLoaded', cargarDatos);
</script>
@endpush
