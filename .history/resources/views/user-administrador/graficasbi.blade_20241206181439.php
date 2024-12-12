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

            <div>
                <label for="urlInput">URL:</label>
                <input type="text" id="urlInput" value="https://dea.wearesmart.co/form-values/7/view" class="form-control">
                <button id="cargarDatosBtn" class="btn btn-primary mt-2">Cargar Datos</button>
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

    function cargarDatos() {
        const urlInput = document.getElementById('urlInput').value;
        const endpoint = '{{ route('api.graficasbi.datos') }}?url=' + encodeURIComponent(urlInput);

        fetch(endpoint)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error HTTP: ${response.status}`);
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
                mostrarError(`Error al cargar datos: ${error.message}`);
            });
    }

    function actualizarGraficos(data) {
        graficoLinea.data.labels = Object.keys(data.totales);
        graficoLinea.data.datasets[0].data = Object.values(data.totales);
        graficoLinea.update();

        graficoTorta.data.labels = Object.keys(data.totales);
        graficoTorta.data.datasets[0].data = Object.values(data.totales);
        graficoTorta.update();
    }

    function mostrarError(mensaje) {
        const alertaError = document.getElementById('alertaError');
        const mensajeError = document.getElementById('mensajeError');
        mensajeError.textContent = mensaje;
        alertaError.classList.remove('d-none');
    }

    document.getElementById('cargarDatosBtn').addEventListener('click', cargarDatos);
</script>
@endpush
