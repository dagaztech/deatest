@extends('layouts.main')

@section('title', __('Gráficas BI'))

@section('content')

<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
            <div class="card" id="purple-btn">
                <div class="card-header">
                    <h5 class="text-center w-100" id="new-title">Gráficas BI</h5>
                </div>
                <div class="card-body form-card-body">
                    <div class="row">
                        <div class="graphicblock">
                            @foreach($charts as $chart)
                                <div class="graphicblocker">
                                    <h6>Formulario ID: {{ $chart['form_id'] }}                                   &nbsp; | &nbsp;<button class="btn btn-sm btn-primary download-chart-data" data-form-id="{{ $chart['form_id'] }}">Descargar Excel</button>
                                    </h6>

                                    <canvas id="chart-{{ $chart['form_id'] }}"></canvas>
                                    <div class="chart-controls">
                                        <label for="chartType-{{ $chart['form_id'] }}">Tipo de Gráfico:</label>
                                        <select id="chartType-{{ $chart['form_id'] }}" class="chart-type-selector">
                                            <option value="bar">Barra</option>
                                            <option value="line">Línea</option>
                                            <option value="pie">Torta</option>
                                            <option value="scatter">Puntos</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="text-center">
                        <button id="download-global" class="btn btn-success">Descarga Global</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="forms-footer">
    <div class="footer-bottom footer-mobile">
        <div class="footer_gov_">
           <div class="centradototal_ fooflex">
              <div class="logos_footer_gov"><a href="https://www.colombia.co" target="_blank"><img class="marcaco_l" src="../../images/logo.png" alt="colombia.co"></a></div>
              <div class="alcaldia_mod_footer"><a href="https://www.medellin.gov.co/es"><img class="log_nww_footer" src="../../images/logo_nav_footer.png" alt="Alcaldía de Medellín"></a></div>
           </div>
        </div>
     </div>
</div>
@endsection

@push('script')
<style>
    .graphicblock { display: block; }
    .graphicblock h6 {
        text-align: center;
        background: #eee;
        padding: 10px;
    }
    .graphicblocker {
        width: 100%;
        margin-bottom: 1em;
        margin-top: 1em;
        border: 1px solid #ccc;
        border-radius: 1em;
        overflow: hidden;
        max-height: 600px;
    }
    .graphicblocker canvas {
        width: 100%;
        height: 600px;
        max-height: 600px;
    }
    .chart-controls {
        text-align: center;
        margin: 10px;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const charts = @json($charts);

        charts.forEach(chart => {
            const ctx = document.getElementById('chart-' + chart.form_id).getContext('2d');

            // Crear gráfico inicial
            const chartInstance = new Chart(ctx, {
                type: chart.type,
                data: {
                    labels: chart.labels,
                    datasets: [{
                        label: 'Datos del Formulario ' + chart.form_id,
                        data: chart.data,
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

            // Cambiar el tipo de gráfico
            document.getElementById('chartType-' + chart.form_id).addEventListener('change', function (e) {
                chartInstance.config.type = e.target.value;
                chartInstance.update();
            });

            // Descargar datos en Excel
            document.querySelector('.download-chart-data[data-form-id="' + chart.form_id + '"]').addEventListener('click', function () {
                window.location.href = `/download-chart-data/${chart.form_id}`;
            });
        });

        // Descargar todos los gráficos en un único Excel
        document.getElementById('download-global').addEventListener('click', function () {
            window.location.href = `/download-global-charts`;
        });
    });
</script>
@endpush
