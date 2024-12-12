@extends('layouts.main')

@section('title', __('Visualización de Tableros (Gráficas BI)'))

@section('content')

<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
            <div class="card" id="purple-btn">
                <div class="card-header">
                    <h5 class="text-center w-100" id="new-title">Visualización de Tableros (Gráficas BI)</h5>
                </div>
                <div class="card-body form-card-body">
                    <div class="row">
                        <div class="graphicblock">
                         
                            @foreach($charts as $chart)
                            <h6>Formulario: {{ $chart['form_name'] }}</h6>
                            <div class="p-3 mt-12">
                                <label for="search-{{ $chart['form_id'] }}">Filtrar:</label>
                                <input type="text" id="search-{{ $chart['form_id'] }}" class="filter-input" data-form-id="{{ $chart['form_id'] }}" placeholder="Escriba para filtrar (junio, julio)">
                                
                                <label for="date-start-{{ $chart['form_id'] }}">Fecha Inicio:</label>
                                <input type="date" id="date-start-{{ $chart['form_id'] }}" class="filter-date" data-form-id="{{ $chart['form_id'] }}">

                                <label for="date-end-{{ $chart['form_id'] }}">Fecha Fin:</label>
                                <input type="date" id="date-end-{{ $chart['form_id'] }}" class="filter-date" data-form-id="{{ $chart['form_id'] }}">
                                
                                <button class="btn btn-sm btn-success download-excel" data-table="table-{{ $chart['form_id'] }}">Descargar Excel</button>
                                <button class="btn btn-sm btn-danger download-pdf" data-table="table-{{ $chart['form_id'] }}">Descargar PDF</button>
                            </div>
                        
                            <!-- Gráfico -->
                            <div class="graphicblocker col-md-6 col-sm-12" data-form-id="{{ $chart['form_id'] }}">
                                <canvas id="chart-{{ $chart['form_id'] }}"></canvas>
                                <div class="chart-controls">
                                    <label for="chartType-{{ $chart['form_id'] }}">Tipo de Gráfico:</label>
                                    <select id="chartType-{{ $chart['form_id'] }}" class="chart-type-selector">
                                        <option value="bar" {{ $chart['type'] == 'bar' ? 'selected' : '' }}>Barra</option>
                                        <option value="line" {{ $chart['type'] == 'line' ? 'selected' : '' }}>Línea</option>
                                        <option value="pie" {{ $chart['type'] == 'pie' ? 'selected' : '' }}>Torta</option>
                                    </select>
                                    <button class="btn btn-sm btn-secondary export-chart-png" data-form-id="{{ $chart['form_id'] }}">
                                        Exportar Gráfico en PNG
                                    </button>
                                </div>
                            </div>
                        
                            <!-- Tabla -->
                            <div class="table-container col-md-5 col-sm-12">
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
                                <!-- Mensaje de "Resultado no encontrado" -->
                                <p class="no-result" id="no-result-{{ $chart['form_id'] }}" style="display:none; text-align:center; color:red;">Resultado no encontrado. Intente con otro término de búsqueda.</p>
                            </div>
                            <p class="clear">&nbsp;</p>
                        @endforeach
                        
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
    /* Estilos sin cambios... */
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

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

            // Cambiar tipo de gráfico
            document.getElementById('chartType-' + chart.form_id).addEventListener('change', function (e) {
                chartInstance.config.type = e.target.value;
                chartInstance.update();
            });

            // Filtrar por texto (múltiples términos)
            document.querySelector(`#search-${chart.form_id}`).addEventListener('input', function () {
                const searchTerms = this.value.toLowerCase().split(',').map(term => term.trim());
                const tablaId = `table-${chart.form_id}`;
                const filas = document.querySelectorAll(`#${tablaId} tbody tr`);
                let filteredData = [];
                let filteredLabels = [];
                let found = false;

                filas.forEach(fila => {
                    const columns = fila.querySelectorAll('td');
                    let matchFound = false;

                    columns.forEach(col => {
                        searchTerms.forEach(term => {
                            if (col.textContent.toLowerCase().includes(term)) {
                                matchFound = true;
                            }
                        });
                    });

                    if (matchFound || searchTerms.length === 0) {
                        fila.style.display = ''; // Mostrar fila
                        filteredData.push(parseInt(columns[1].textContent));
                        filteredLabels.push(columns[0].textContent);
                    } else {
                        fila.style.display = 'none'; // Ocultar fila
                    }

                    if (matchFound) found = true;
                });

                if (found) {
                    document.getElementById(`no-result-${chart.form_id}`).style.display = 'none';
                    chartInstance.data.labels = filteredLabels;
                    chartInstance.data.datasets[0].data = filteredData;
                    chartInstance.update();
                } else {
                    document.getElementById(`no-result-${chart.form_id}`).style.display = 'block';
                }
            });

            // Filtrar por fecha (rango de fechas)
            document.querySelector(`#date-start-${chart.form_id}`).addEventListener('input', filterByDate);
            document.querySelector(`#date-end-${chart.form_id}`).addEventListener('input', filterByDate);

            function filterByDate() {
                const startDate = document.querySelector(`#date-start-${chart.form_id}`).value;
                const endDate = document.querySelector(`#date-end-${chart.form_id}`).value;
                const tablaId = `table-${chart.form_id}`;
                const filas = document.querySelectorAll(`#${tablaId} tbody tr`);
                let filteredData = [];
                let filteredLabels = [];

                filas.forEach(fila => {
                    const dateLabel = fila.querySelector('td').textContent;
                    const month = getMonthFromDate(dateLabel); // Función para obtener el mes

                    // Filtrar por fecha
                    if ((startDate && new Date(startDate) <= new Date(dateLabel)) &&
                        (endDate && new Date(endDate) >= new Date(dateLabel))) {
                        fila.style.display = '';
                        filteredData.push(parseInt(fila.children[1].textContent));
                        filteredLabels.push(month);
                    } else {
                        fila.style.display = 'none';
                    }
                });

                // Actualizar gráfico con los datos filtrados
                chartInstance.data.labels = filteredLabels;
                chartInstance.data.datasets[0].data = filteredData;
                chartInstance.update();
            }

            // Función para obtener el mes de una fecha (Ejemplo: "enero", "febrero")
            function getMonthFromDate(date) {
                const months = [
                    "enero", "febrero", "marzo", "abril", "mayo", "junio", 
                    "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"
                ];
                const dateObj = new Date(date);
                return months[dateObj.getMonth()];
            }
        });

        // Descargar Excel y PDF
        // (Lógica ya existente para la exportación a Excel y PDF)
    });
</script>
@endpush