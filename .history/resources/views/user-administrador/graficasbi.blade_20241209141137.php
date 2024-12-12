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
                            <h6>Formulario: {{ $chart['form_name'] }}</h6>
                            
                            
                            <!-- Filtros -->

<label for="fecha-rango-{{ $chart['form_id'] }}">Filtrar por Rango de Fechas:</label>
<input type="date" id="fecha-inicio-{{ $chart['form_id'] }}" class="filter-date range-start" data-form-id="{{ $chart['form_id'] }}">
<input type="date" id="fecha-fin-{{ $chart['form_id'] }}" class="filter-date range-end" data-form-id="{{ $chart['form_id'] }}">


                                <div class="graphicblocker" data-form-id="{{ $chart['form_id'] }}">
                                    <canvas id="chart-{{ $chart['form_id'] }}"></canvas>

                                    <div class="chart-controls">
                                        <label for="chartType-{{ $chart['form_id'] }}">Tipo de Gráfico:</label>
                                        <select id="chartType-{{ $chart['form_id'] }}" class="chart-type-selector">
                                            <option value="bar" {{ $chart['type'] == 'bar' ? 'selected' : '' }}>Barra</option>
                                            <option value="line" {{ $chart['type'] == 'line' ? 'selected' : '' }}>Línea</option>
                                            <option value="pie" {{ $chart['type'] == 'pie' ? 'selected' : '' }}>Torta</option>
                                        </select>
                                    </div>

                                    <!-- Filtro por fecha -->
                                    <label for="fecha-{{ $chart['form_id'] }}">Filtrar por Fecha:</label>
                                    <input type="date" id="fecha-{{ $chart['form_id'] }}" class="filter-date" data-table="table-{{ $chart['form_id'] }}">
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
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-success download-excel" data-table="table-{{ $chart['form_id'] }}">Descargar Excel</button>
                                    <button class="btn btn-sm btn-danger download-pdf" data-table="table-{{ $chart['form_id'] }}">Descargar PDF</button>
                                </div>
                                <p>&nbsp;</p>
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
        height: 550px;
        max-height:550px;
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
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
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

        // Función para bloquear los filtros
        function disableOtherFilters(except) {
            const filters = document.querySelectorAll(`.filter-date[data-form-id="${chart.form_id}"]`);
            filters.forEach(filter => {
                if (filter !== except) {
                    filter.disabled = true;
                }
            });
        }

        // Función para habilitar todos los filtros
        function enableAllFilters() {
            const filters = document.querySelectorAll(`.filter-date[data-form-id="${chart.form_id}"]`);
            filters.forEach(filter => {
                filter.disabled = false;
            });
        }

        // Filtrar por Día Exacto
        document.querySelector(`#fecha-dia-${chart.form_id}`).addEventListener('change', function () {
            enableAllFilters(); // Rehabilitar todos los filtros antes de aplicar uno

            // Deshabilitar otros filtros
            disableOtherFilters(this);

            const fechaSeleccionada = this.value;
            const tablaId = `table-${chart.form_id}`;
            const filas = document.querySelectorAll(`#${tablaId} tbody tr`);
            let filteredData = [];
            let filteredLabels = [];

            filas.forEach(fila => {
                const fecha = fila.children[0].textContent;
                if (fecha === fechaSeleccionada || fechaSeleccionada === '') {
                    fila.style.display = ''; // Mostrar fila
                    const dataValue = parseInt(fila.children[1].textContent);
                    filteredData.push(dataValue);
                    filteredLabels.push(fila.children[0].textContent);
                } else {
                    fila.style.display = 'none'; // Ocultar fila
                }
            });

            // Actualizar gráfico con los datos filtrados
            chartInstance.data.labels = filteredLabels;
            chartInstance.data.datasets[0].data = filteredData;
            chartInstance.update();
        });

        // Filtrar por Mes
        document.querySelector(`#fecha-mes-${chart.form_id}`).addEventListener('change', function () {
            enableAllFilters(); // Rehabilitar todos los filtros antes de aplicar uno

            // Deshabilitar otros filtros
            disableOtherFilters(this);

            const mesSeleccionado = this.value;
            const tablaId = `table-${chart.form_id}`;
            const filas = document.querySelectorAll(`#${tablaId} tbody tr`);
            let filteredData = [];
            let filteredLabels = [];

            filas.forEach(fila => {
                const fecha = fila.children[0].textContent;
                const fechaMes = fecha.substring(0, 7); // Formato "YYYY-MM"
                if (fechaMes === mesSeleccionado || mesSeleccionado === '') {
                    fila.style.display = ''; // Mostrar fila
                    const dataValue = parseInt(fila.children[1].textContent);
                    filteredData.push(dataValue);
                    filteredLabels.push(fila.children[0].textContent);
                } else {
                    fila.style.display = 'none'; // Ocultar fila
                }
            });

            // Actualizar gráfico con los datos filtrados
            chartInstance.data.labels = filteredLabels;
            chartInstance.data.datasets[0].data = filteredData;
            chartInstance.update();
        });

        // Filtrar por Rango de Fechas
        document.querySelector(`#fecha-inicio-${chart.form_id}`).addEventListener('change', function () {
            enableAllFilters(); // Rehabilitar todos los filtros antes de aplicar uno

            // Deshabilitar otros filtros
            disableOtherFilters(this);

            const fechaInicio = this.value;
            const fechaFin = document.querySelector(`#fecha-fin-${chart.form_id}`).value;
            const tablaId = `table-${chart.form_id}`;
            const filas = document.querySelectorAll(`#${tablaId} tbody tr`);
            let filteredData = [];
            let filteredLabels = [];

            filas.forEach(fila => {
                const fecha = fila.children[0].textContent;
                if ((fecha >= fechaInicio && fecha <= fechaFin) || (fechaInicio === '' && fechaFin === '')) {
                    fila.style.display = ''; // Mostrar fila
                    const dataValue = parseInt(fila.children[1].textContent);
                    filteredData.push(dataValue);
                    filteredLabels.push(fila.children[0].textContent);
                } else {
                    fila.style.display = 'none'; // Ocultar fila
                }
            });

            // Actualizar gráfico con los datos filtrados
            chartInstance.data.labels = filteredLabels;
            chartInstance.data.datasets[0].data = filteredData;
            chartInstance.update();
        });

        document.querySelector(`#fecha-fin-${chart.form_id}`).addEventListener('change', function () {
            enableAllFilters(); // Rehabilitar todos los filtros antes de aplicar uno

            // Deshabilitar otros filtros
            disableOtherFilters(this);

            const fechaInicio = document.querySelector(`#fecha-inicio-${chart.form_id}`).value;
            const fechaFin = this.value;
            const tablaId = `table-${chart.form_id}`;
            const filas = document.querySelectorAll(`#${tablaId} tbody tr`);
            let filteredData = [];
            let filteredLabels = [];

            filas.forEach(fila => {
                const fecha = fila.children[0].textContent;
                if ((fecha >= fechaInicio && fecha <= fechaFin) || (fechaInicio === '' && fechaFin === '')) {
                    fila.style.display = ''; // Mostrar fila
                    const dataValue = parseInt(fila.children[1].textContent);
                    filteredData.push(dataValue);
                    filteredLabels.push(fila.children[0].textContent);
                } else {
                    fila.style.display = 'none'; // Ocultar fila
                }
            });

            // Actualizar gráfico con los datos filtrados
            chartInstance.data.labels = filteredLabels;
            chartInstance.data.datasets[0].data = filteredData;
            chartInstance.update();
        });
    });

    // Descargar Excel con nombre personalizado
    document.querySelectorAll('.download-excel').forEach(button => {
        button.addEventListener('click', function () {
            const tableId = this.dataset.table;
            const tabla = document.getElementById(tableId);
            const formName = tabla.closest('.graphicblock').querySelector('h6').textContent.split(": ")[1].split('|')[0].trim();

            // Crear libro de Excel y exportar con nombre personalizado
            const wb = XLSX.utils.table_to_book(tabla, { sheet: "Datos" });
            XLSX.writeFile(wb, `${formName.replace(/\s+/g, '_')}_datos.xlsx`);
        });
    });

    // Descargar PDF
    document.querySelectorAll('.download-pdf').forEach(button => {
        button.addEventListener('click', function () {
            const tableId = this.dataset.table;
            const tabla = document.getElementById(tableId);
            const formName = tabla.closest('.graphicblock').querySelector('h6').textContent.split(": ")[1].split('|')[0].trim();
            const canvasId = `chart-${tableId.split('-')[1]}`;
            const canvas = document.getElementById(canvasId);

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Incluir título del formulario
            doc.setFontSize(16);
            doc.text(`Formulario: ${formName}`, 10, 10);

            // Agregar imagen del gráfico
            const imgData = canvas.toDataURL('image/png');
            doc.addImage(imgData, 'PNG', 10, 20, 180, 80);

            // Agregar tabla al PDF
            let y = 110; // Posición inicial después del gráfico
            tabla.querySelectorAll('tr').forEach((fila, index) => {
                const celdas = fila.querySelectorAll('td, th');
                let texto = '';

                celdas.forEach(celda => {
                    texto += `${celda.textContent} \t`;
                });

                doc.text(texto, 10, y);
                y += 10;
            });

            doc.save(`${formName.replace(/\s+/g, '_')}_datos.pdf`);
        });
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const charts = @json($charts);

    charts.forEach(chart => {
        const chartId = 'chart-' + chart.form_id;
        const tableId = 'table-' + chart.form_id;

        const ctx = document.getElementById(chartId).getContext('2d');

        // Guardar datos iniciales
        const originalData = JSON.parse(JSON.stringify(chart.data));
        const originalLabels = [...chart.labels];

        const chartInstance = new Chart(ctx, {
            type: chart.type,
            data: {
                labels: originalLabels,
                datasets: [{
                    label: 'Datos del Formulario ' + chart.form_id,
                    data: originalData,
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
                maintainAspectRatio: false
            }
        });

        // Función para resetear filtros
        document.querySelector(`.reset-filters[data-chart="${chartId}"]`).addEventListener('click', function () {
            // Resetear la tabla
            const tableRows = document.querySelectorAll(`#${tableId} tbody tr`);
            tableRows.forEach(row => {
                row.style.display = ''; // Mostrar todas las filas
            });

            // Resetear el gráfico
            chartInstance.data.labels = originalLabels;
            chartInstance.data.datasets[0].data = originalData;
            chartInstance.update();

            // Resetear inputs de fecha y mes
            document.getElementById(`dia-exacto-${chart.form_id}`).value = '';
            document.getElementById(`mes-${chart.form_id}`).value = '';
            document.getElementById(`rango-inicio-${chart.form_id}`).value = '';
            document.getElementById(`rango-fin-${chart.form_id}`).value = '';
        });
    });
});
</script>
@endpush
