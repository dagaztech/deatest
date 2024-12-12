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

                    <div class="mx-auto mb-4 mt-0 row col-md-4">
                        <button id="download-global" class="btn btn-success" onclick="window.location.href='{{ route('download.global.charts') }}'">
                            Descarga Global
                        </button>
                    </div>
                        <hr>

                        <div class="graphicblock">
                            @foreach($charts as $chart)
                            <h6>Formulario ID: {{ $chart['form_id'] }}                                   &nbsp; | &nbsp;
                                <a href="{{ route('download.chart.data', ['form_id' => $chart['form_id']]) }}" class="btn btn-sm btn-primary">Descargar Excel</a>
                            </h6>
                                <div class="graphicblocker" data-form-id="{{ $chart['form_id'] }}">
                                 

                                  

                                    <canvas id="chart-{{ $chart['form_id'] }}"></canvas>

                                    <div class="chart-controls">
                                        <label for="chartType-{{ $chart['form_id'] }}">Tipo de Gráfico:</label>
                                        <select id="chartType-{{ $chart['form_id'] }}" class="chart-type-selector">
                                            <option value="bar" {{ $chart['type'] == 'bar' ? 'selected' : '' }}>Barra</option>
                                            <option value="line" {{ $chart['type'] == 'line' ? 'selected' : '' }}>Línea</option>
                                            <option value="pie" {{ $chart['type'] == 'pie' ? 'selected' : '' }}>Torta</option>
                                            <option value="scatter" {{ $chart['type'] == 'scatter' ? 'selected' : '' }}>Puntos</option>
                                        </select>
                                    </div>
                               
                                </div>
                                

                            @endforeach


                            <div class="table-container">
                                <h6>Datos del Formulario ID: {{ $chart['form_id'] }}</h6>
                                <table class="table" id="table-{{ $chart['form_id'] }}">
                                    <thead>
                                        <tr>
                                            <th>Mes</th>
                                            <th>Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($chart['data'] as $index => $value)
                                            <tr>
                                                <td>{{ $chart['labels'][$index] }}</td>
                                                <td>{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                 
                        </div>

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
                <div class="logos_footer_gov">
                    <a href="https://www.colombia.co" target="_blank"><img class="marcaco_l" src="../../images/logo.png" alt="colombia.co"></a>
                </div>
                <div class="alcaldia_mod_footer">
                    <a href="https://www.medellin.gov.co/es"><img class="log_nww_footer" src="../../images/logo_nav_footer.png" alt="Alcaldía de Medellín"></a>
                </div>
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
    width: 48%;
    margin-bottom: 1em;
    margin-top: 1em;
    border: 1px solid #ccc;
    border-radius: 1em;
    overflow: hidden;
    max-height: 600px;
    float: left;
    margin-left: 1%;
    margin-right: 1%;
}
    .graphicblocker canvas {
        width: 100%;
        height: 450px;
        max-height:450px;
    }
    .chart-controls {
        text-align: center;
        margin: 10px;
    }
    .table-container {
    margin-top: 1em;
    border: 1px solid #ccc;
    border-radius: 1em;
    overflow: hidden;
    max-width: 48%;
}
.table {
    width: 100%;
    border-collapse: collapse;
}
.table th, .table td {
    padding: 8px;
    text-align: center;
    border: 1px solid #ccc;
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
                type: chart.type,  // Tipo de gráfico basado en el valor inicial del servidor
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
        });

        // Descargar todos los gráficos en un único Excel
        document.getElementById('download-global').addEventListener('click', function () {
            window.location.href = '{{ route('download.global.charts') }}';
        });
    });
</script>
@endpush
