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
                            Descarga Global de Datos
                        </button>
                    </div>
                        <hr>
                        
                        <div class="graphicblock">
                            @foreach($charts as $chart)
                            <h6>Formulario: {{ $chart['form_name'] }}                                 &nbsp; | &nbsp;
                                <a href="{{ route('download.chart.data', ['form_id' => $chart['form_id']]) }}" class="btn btn-sm btn-primary">Descargar Datos</a>
                            </h6>
                            <form id="filterForm" method="GET" action="{{ route('user-administrador.graficasbi') }}" class="mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="startDate">Fecha de Inicio:</label>
                                        <input type="date" id="startDate" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="endDate">Fecha de Fin:</label>
                                        <input type="date" id="endDate" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                    </div>
                                    <div class="col-md-4">
                                    <label for="chartType-{{ $chart['form_id'] }}">Tipo de Gráfico:</label><br>
                                    <select id="chartType-{{ $chart['form_id'] }}" class="chart-type-selector">
                                        <option value="bar" {{ $chart['type'] == 'bar' ? 'selected' : '' }}>Barra</option>
                                        <option value="line" {{ $chart['type'] == 'line' ? 'selected' : '' }}>Línea</option>
                                        <option value="pie" {{ $chart['type'] == 'pie' ? 'selected' : '' }}>Torta</option>
                                    </select>
                                     </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                                    </div>
                                </div>
                            </form>
                                <div class="graphicblocker" data-form-id="{{ $chart['form_id'] }}">
                                    <canvas id="chart-{{ $chart['form_id'] }}"></canvas>
                                </div>
                                <div class="table-container">
                                    
                                    <table class="table" id="table-{{ $chart['form_id'] }}">
                                        <thead>
                                            <tr>
                                                <th>Mes</th>
                                                <th>Registros</th>
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
                                <p>&nbsp;</p>
                                <hr>
                            @endforeach

                            @if(!empty($charts))
    @foreach($charts as $chart)
        <h6>Formulario: {{ $chart['form_name'] }}</h6>
        <div>
            <canvas id="chart-{{ $chart['form_id'] }}"></canvas>
        </div>
    @endforeach
@else
    <p>No hay gráficos disponibles para mostrar.</p>
@endif
                        
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
    .graphicblock { display: block;
    margin-bottom:2em; }
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
    max-height: 590px;
    float: left;
    margin-left: 1%;
    margin-right: 3%;
}
    .graphicblocker canvas {
        width: 100%;
        height: 580px;
        max-height:580px;
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
    max-height:590px;
    height:590px;
}
.table th, .table td {
    padding: 8px;
    text-align: center;
    border: 1px solid #ccc;
}
.chart-type-selector{
    line-height: 1em;
    padding: 0.5em;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
    const charts = @json($charts);

    charts.forEach(chart => {
        const ctx = document.getElementById('chart-' + chart.form_id).getContext('2d');

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
        });

        // Descargar todos los gráficos en un único Excel
        document.getElementById('download-global').addEventListener('click', function () {
            window.location.href = '{{ route('download.global.charts') }}';
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const charts = @json($charts);

    charts.forEach(chart => {
        const ctx = document.getElementById('chart-' + chart.form_id).getContext('2d');

        let chartInstance = new Chart(ctx, {
            type: chart.type,
            data: {
                labels: chart.labels,
                datasets: [{
                    label: 'Datos del Formulario ' + chart.form_id,
                    data: chart.data,
                    backgroundColor: [...],
                    borderColor: [...],
                    borderWidth: 1,
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Aplicar filtros
        document.querySelector(`.apply-filters[data-form-id="${chart.form_id}"]`).addEventListener('click', function () {
            const startDate = document.getElementById('startDate-' + chart.form_id).value;
            const endDate = document.getElementById('endDate-' + chart.form_id).value;
            const location = document.getElementById('locationFilter-' + chart.form_id).value;

            fetch(`/api/charts/${chart.form_id}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ startDate, endDate, location }),
            })
                .then(response => response.json())
                .then(updatedData => {
                    chartInstance.data.labels = updatedData.labels;
                    chartInstance.data.datasets[0].data = updatedData.data;
                    chartInstance.update();
                });
        });
    });
});
</script>
@endpush
