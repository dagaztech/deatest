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
                    <button id="download-global" class="btn btn-success" onclick="window.location.href='{{ route('download.global.charts') }}'">
                        Descarga Global
                    </button>
                    <div class="row">
                        <div class="graphicblock">
                            @foreach($charts as $chart)
                                <div class="graphicblocker" data-form-id="{{ $chart['form_id'] }}">
                                    <div class="search-bar">
                                        <label for="searchInput">Buscar Formulario:</label>
                                        <input type="text" id="searchInput" placeholder="Escribe el ID o un nombre">
                                    </div>

                                    <h6>Formulario ID: {{ $chart['form_id'] }}                                   &nbsp; | &nbsp;
                                        <a href="{{ route('download.chart.data', ['form_id' => $chart['form_id']]) }}" class="btn btn-sm btn-primary">Descargar Excel</a>
                                    </h6>

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
                        </div>
                    </div>
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

 @foreach ($charts as $chart)
    <div class="chart-container">
        <h5>{{ $chart['form_name'] }} (ID: {{ $chart['form_id'] }})</h5>

        @foreach ($chart['columns'] as $column)
            <h6>Columna: {{ $column }}</h6>
            <canvas id="chart-{{ $chart['form_id'] }}-{{ $column }}"></canvas>
        @endforeach
    </div>
 @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="chart-column-selector">
                        <label for="columnSelector-{{ $chart['form_id'] }}">Seleccionar Columna:</label>
                        <select id="columnSelector-{{ $chart['form_id'] }}" class="column-selector">
                            <option value="default" selected>-- Seleccionar Columna --</option>
                            @foreach($chart['columns'] as $column)
                                <option value="{{ $column }}">{{ $column }}</option>
                            @endforeach
                        </select>
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
        height: 450px;
        max-height:450px;
    }
    .chart-controls {
        text-align: center;
        margin: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  /*  document.addEventListener('DOMContentLoaded', function () {
        const charts = @json($charts);

        charts.forEach(chart => {
    const columnSelector = document.getElementById('columnSelector-' + chart.form_id);

    columnSelector.addEventListener('change', function (e) {
        const selectedColumn = e.target.value;

        if (selectedColumn !== 'default') {
            // Simulación: Reemplaza esto con datos reales según la columna
            const newData = chart.data.map(value => Math.floor(Math.random() * 100));

            chartInstance.data.datasets[0].data = newData;
            chartInstance.data.datasets[0].label = 'Datos de ' + selectedColumn;
            chartInstance.update();
        }
    });
});


        // Descargar todos los gráficos en un único Excel
        document.getElementById('download-global').addEventListener('click', function () {
            window.location.href = '{{ route('download.global.charts') }}';
        });
    });*/

    document.addEventListener('DOMContentLoaded', function () {
    const charts = @json($charts);

    charts.forEach(chart => {
        chart.columns.forEach(column => {
            const ctx = document.getElementById(`chart-${chart.form_id}-${column}`).getContext('2d');

            new Chart(ctx, {
                type: 'bar', // Tipo inicial, puedes hacerlo dinámico
                data: {
                    labels: chart.labels,
                    datasets: [{
                        label: `Datos de ${column}`,
                        data: chart.data[column],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    });
});

</script>
<script>
    document.getElementById('searchInput').addEventListener('input', function (e) {
    const searchTerm = e.target.value.toLowerCase();
    const graphicBlocks = document.querySelectorAll('.graphicblocker');

    graphicBlocks.forEach(block => {
        const formId = block.getAttribute('data-form-id');
        const title = block.querySelector('h6').innerText.toLowerCase();

        if (formId.includes(searchTerm) || title.includes(searchTerm)) {
            block.style.display = '';
        } else {
            block.style.display = 'none';
        }
    });
});
</script>
@endpush
