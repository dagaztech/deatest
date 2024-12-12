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
                            Descarga Global de Datos en XLS
                        </button>
                    </div>
                        <hr>
                        
                        <div class="graphicblock">
                            @foreach($charts as $chart)
                            <h6>Formulario: {{ $chart['form_name'] }}                                 &nbsp; | &nbsp;
                                <a href="{{ route('download.chart.data', ['form_id' => $chart['form_id']]) }}" class="btn btn-sm btn-primary">Descargar Excel</a> 
                            </h6>
                            <form id="filterForm-{{ $chart['form_id'] }}" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="startDate-{{ $chart['form_id'] }}">Fecha de Inicio:</label>
                                        <input type="date" id="startDate-{{ $chart['form_id'] }}" name="start_date" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="endDate-{{ $chart['form_id'] }}">Fecha de Fin:</label>
                                        <input type="date" id="endDate-{{ $chart['form_id'] }}" name="end_date" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="chartType-{{ $chart['form_id'] }}">Tipo de Gráfico:</label><br>
                                        <select id="chartType-{{ $chart['form_id'] }}" class="chart-type-selector">
                                            <option value="bar" {{ $chart['type'] == 'bar' ? 'selected' : '' }}>Barra</option>
                                            <option value="line" {{ $chart['type'] == 'line' ? 'selected' : '' }}>Línea</option>
                                            <option value="pie" {{ $chart['type'] == 'pie' ? 'selected' : '' }}>Torta</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <button type="button" class="btn btn-primary apply-filters" data-form-id="{{ $chart['form_id'] }}">Aplicar Filtros</button>&nbsp;<button type="button" class="btn btn-secondary reset-filters" onClick="window.location.reload();">Restablecer Filtros</button>
                                    </div>
                                </div>
                            </form>
                            
                                <div class="graphicblocker col-lg-6 col-md-6 col-sm-12" data-form-id="{{ $chart['form_id'] }}">
                                    <canvas id="chart-{{ $chart['form_id'] }}"></canvas>
                                    <button class="btn btn-sm btn-secondary export-chart-png" data-form-id="{{ $chart['form_id'] }}">
                                        Exportar Gráfico en PNG
                                    </button>
                                </div>
                                <div class="table-container col-lg-5 col-md-5 col-sm-12">
                                    
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
                                <p class="clear">&nbsp;</p>
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
        margin-bottom: 1em;
    margin-top: 1em;
    border: 1px solid #ccc;
    border-radius: 1em;
    max-height: 590px;
    float: left;
    margin-left: 1%;
    margin-right: 1%;
    display: inline-block;
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
    float: left;
    display: inline;
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
p.clear{
    clear: both;
    width: 100%;
}
.mb-4 .col-md-4.text-center{
    padding-top: 2em;
}
@media all and (max-width:768px){
    .graphicblock h6 a {
    margin-top: 0.5em;
}
.mb-4 .col-md-4.text-center{
    padding-top: 0em;
}
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.2/jspdf.umd.min.js"></script>

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
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
            }
        });

        // Manejar el evento "Aplicar Filtros"
        document.querySelector(`.apply-filters[data-form-id="${chart.form_id}"]`).addEventListener('click', function () {
            const startDate = document.getElementById('startDate-' + chart.form_id).value;
            const endDate = document.getElementById('endDate-' + chart.form_id).value;
            const chartType = document.getElementById('chartType-' + chart.form_id).value;

            fetch(`/api/charts/${chart.form_id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token para proteger la solicitud
                },
                body: JSON.stringify({
                    start_date: startDate,
                    end_date: endDate,
                    type: chartType,
                }),
            })
            .then(response => response.json())
            .then(updatedData => {
                // Actualizar el tipo de gráfico
                chartInstance.config.type = chartType;

                // Actualizar datos del gráfico
                chartInstance.data.labels = updatedData.labels;
                chartInstance.data.datasets[0].data = updatedData.data;
                chartInstance.update();

                // Actualizar la tabla
                const tableBody = document.querySelector(`#table-${chart.form_id} tbody`);
                tableBody.innerHTML = ''; // Limpiar la tabla
                updatedData.labels.forEach((label, index) => {
                    const row = `<tr><td>${label}</td><td>${updatedData.data[index]}</td></tr>`;
                    tableBody.innerHTML += row;
                });
            })
            .catch(error => console.error('Error al aplicar filtros:', error));
        });
    });
});
</script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.download-chart-data').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();

            const formId = button.getAttribute('data-form-id');
            const startDate = document.getElementById('startDate-' + formId).value;
            const endDate = document.getElementById('endDate-' + formId).value;

            // Redirigir con los filtros como parámetros de consulta
            const downloadUrl = `/charts/download/${formId}?start_date=${startDate}&end_date=${endDate}`;
            window.location.href = downloadUrl;
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Resetea los filtros cuando el botón de reset es presionado
    document.querySelectorAll('.reset-filters').forEach(function(button) {
        button.addEventListener('click', function() {
            const formId = button.getAttribute('data-form-id');
            const form = document.getElementById('filterForm-' + formId);

            // Restablecer los valores del formulario
            form.reset();

            // Restablecer el tipo de gráfico al valor por defecto
            const chartTypeSelector = document.getElementById('chartType-' + formId);
            chartTypeSelector.value = chartTypeSelector.querySelector('option[selected]').value;

            // Restablecer la tabla y la gráfica a su estado original
            resetChartAndTable(formId);
        });
    });

    // Función que reseteará la gráfica y la tabla
    function resetChartAndTable(formId) {
        // Obtener los datos originales desde el backend
        const originalData = @json($charts); // Asegúrate de que los datos originales estén disponibles en el frontend

        // Buscar el gráfico correspondiente por su form_id
        const chartData = originalData.find(chart => chart.form_id == formId);

        if (chartData) {
            // Restaurar la gráfica
            const ctx = document.getElementById('chart-' + formId).getContext('2d');
            const chartInstance = Chart.instances.find(c => c.canvas.id === 'chart-' + formId);

            if (chartInstance) {
                // Restaurar los datos de la gráfica
                chartInstance.data.labels = chartData.labels;
                chartInstance.data.datasets[0].data = chartData.data;
                chartInstance.update();
            }

            // Restaurar la tabla
            const tableBody = document.querySelector(`#table-${formId} tbody`);
            tableBody.innerHTML = ''; // Limpiar la tabla

            // Agregar los datos originales a la tabla
            chartData.data.forEach((value, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${chartData.labels[index]}</td>
                    <td>${value}</td>
                `;
                tableBody.appendChild(row);
            });
        }
    }
});
</script>
<script>
document.getElementById('download-global-pdf').addEventListener('click', function () {
    const doc = new jsPDF();
    const charts = @json($charts);

    charts.forEach((chart, index) => {
        // Añadir título para cada formulario
        doc.text(`Formulario: ${chart.form_name}`, 10, 10 + (index * 40));

        // Añadir tabla
        const tableData = chart.data.map((value, i) => [chart.labels[i], value]);
        doc.autoTable({
            startY: 20 + (index * 40),
            head: [['Mes', 'Registros']],
            body: tableData,
        });

        // Añadir gráfico
        const canvas = document.getElementById(`chart-${chart.form_id}`);
        const imgData = canvas.toDataURL('image/png');
        doc.addImage(imgData, 'PNG', 10, doc.lastAutoTable.finalY + 10, 180, 100);
    });

    doc.save('informacion-global.pdf');
});
</script>
<script>
document.querySelectorAll('.export-form-pdf').forEach(button => {
    button.addEventListener('click', function () {
        const formId = button.getAttribute('data-form-id');
        const chart = charts.find(c => c.form_id == formId);

        const doc = new jsPDF();

        // Añadir título del formulario
        doc.text(`Formulario: ${chart.form_name}`, 10, 10);

        // Añadir la tabla
        const tableData = chart.data.map((value, i) => [chart.labels[i], value]);
        doc.autoTable({
            startY: 20,
            head: [['Mes', 'Registros']],
            body: tableData,
        });

        // Añadir gráfico
        const canvas = document.getElementById(`chart-${formId}`);
        canvas.toBlob(function(blob) {
            const imgData = URL.createObjectURL(blob);
            doc.addImage(imgData, 'PNG', 10, doc.lastAutoTable.finalY + 10, 180, 100);

            // Guardar el PDF
            doc.save(`${chart.form_name}.pdf`);
        });
    });
});
</script>
<script>
    // Exportar gráfico a PNG
document.querySelectorAll('.export-chart-png').forEach(button => {
    button.addEventListener('click', function () {
        const formId = button.getAttribute('data-form-id');
        const canvas = document.getElementById(`chart-${formId}`);
        const imgData = canvas.toDataURL('image/png');
        const link = document.createElement('a');
        link.href = imgData;
        link.download = `grafico-${formId}.png`;
        link.click();
    });
});
</script>
@endpush
