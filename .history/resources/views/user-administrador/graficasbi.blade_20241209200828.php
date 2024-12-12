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
                            
         <div class="mt-12 p-3">
            <label for="fecha-{{ $chart['form_id'] }}">Filtrar por Fecha:</label>
         <input type="date" id="fecha-{{ $chart['form_id'] }}" class="filter-date" data-form-id="{{ $chart['form_id'] }}">
            <button class="btn btn-sm btn-success download-excel" data-table="table-{{ $chart['form_id'] }}">Descargar Excel</button>
            <button class="btn btn-sm btn-danger download-pdf" data-table="table-{{ $chart['form_id'] }}">Descargar PDF</button>
        </div>
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
    padding: 4px;
    margin-right: 1em;
}
.clear{
    clear:both;
    width:100%;
}
@media all and (max-width:768px){
   .download-excel, .download-pdf, .filter-date {
    width: 100%;
    margin: 10px 0;
}
.table-container {
    padding: 0;
}
.graphicblocker{
    padding: 0;
    margin: 0;
}
.mt-5, .section-body .mx-0.mt-5.row{
    margin-top:2em;
}
.table, .graphicblocker {
        height: auto !important;
        max-height: fit-content !important;
    }
}
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

        // Filtrar por fecha
        document.querySelector(`#fecha-${chart.form_id}`).addEventListener('change', function () {
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
       // Descargar PDF con gráfico
       document.querySelectorAll('.download-pdf').forEach(button => {
    button.addEventListener('click', function () {
        const tableId = this.dataset.table;
        const tabla = document.getElementById(tableId);
        const formName = tabla.closest('.graphicblock').querySelector('h6').textContent.split(": ")[1].split('|')[0].trim();
        const canvasId = `chart-${tableId.split('-')[1]}`;
        const canvas = document.getElementById(canvasId);

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('landscape'); // Establecer formato horizontal

        // Incluir título del formulario
        doc.setFontSize(16);
        doc.text(`Formulario: ${formName}`, 148, 20, { align: 'center' }); // Texto centrado

        // Agregar imagen del gráfico
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = 180; // Ancho de la imagen
        const imgHeight = (canvas.height * imgWidth) / canvas.width; // Mantener proporciones
        const xPos = (doc.internal.pageSize.getWidth() - imgWidth) / 2; // Centrar horizontalmente
        const yPos = 30; // Espaciado superior
        doc.addImage(imgData, 'PNG', xPos, yPos, imgWidth, imgHeight);

        // Agregar tabla al PDF
        const yStart = yPos + imgHeight + 10; // Espaciado después del gráfico
        const columnHeaders = [];
        const rowData = [];

        // Obtener encabezados
        tabla.querySelectorAll('thead th').forEach(th => columnHeaders.push(th.textContent));

        // Obtener datos de filas
        tabla.querySelectorAll('tbody tr').forEach(row => {
            const rowContent = [];
            row.querySelectorAll('td').forEach(td => rowContent.push(td.textContent));
            rowData.push(rowContent);
        });

        // Dibujar tabla con líneas visibles
        doc.autoTable({
            startY: yStart,
            head: [columnHeaders],
            body: rowData,
            styles: { halign: 'center', valign: 'middle' },
            theme: 'grid', // Tema para incluir líneas
        });

        // Guardar el archivo con el nombre personalizado
        doc.save(`${formName.replace(/\s+/g, '_')}_datos.pdf`);
    });
});

    });
</script>
<script>
// Exportar gráfico a PNG
document.querySelectorAll('.export-chart-png').forEach(button => {
    button.addEventListener('click', function () {
        const formId = button.getAttribute('data-form-id');
        const canvas = document.getElementById(`chart-${formId}`); // Corregido con comillas invertidas
        if (canvas) {
            const imgData = canvas.toDataURL('image/png'); // Obtener datos en formato PNG
            const link = document.createElement('a');
            link.href = imgData;
            link.download = `grafico-${formId}.png`; // Corregido nombre del archivo
            link.click(); // Descargar el archivo
        } else {
            console.error(`No se encontró el canvas con ID: chart-${formId}`);
        }
    });
});
</script>
@endpush
