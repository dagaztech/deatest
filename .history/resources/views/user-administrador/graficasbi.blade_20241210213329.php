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
                                <input type="text" id="search-{{ $chart['form_id'] }}" class="filter-input w-50" data-form-id="{{ $chart['form_id'] }}" placeholder="Escriba para filtrar: mes, número o fecha tipo DDMMYY, DD-MM-YY, y DD/MM/YY">
                                
                       
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

<!--script>
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

            document.querySelector(`#search-${chart.form_id}`).addEventListener('input', function () {
                const searchTerm = this.value.toLowerCase();
                const tablaId = `table-${chart.form_id}`;
                const filas = document.querySelectorAll(`#${tablaId} tbody tr`);
                let filteredData = [];
                let filteredLabels = [];
                let found = false;

                // Expresión regular para fechas
                const regexFecha = /^(\d{2})([-\/\s]?)(\d{2})\2?(\d{2,4})?$/; // Formatos DDMMYY, DD-MM-YY, DD/MM/YY
                const matchFecha = searchTerm.match(regexFecha);

                if (matchFecha) {
                    const dia = matchFecha[1];
                    const mes = matchFecha[3];
                    const anio = matchFecha[4] || new Date().getFullYear().toString().slice(-2); // Año actual si no está presente
                    const fecha = new Date(`20${anio}`, mes - 1, dia);
                    const mesNombre = fecha.toLocaleString('es-ES', { month: 'long' });

                    filas.forEach(fila => {
                        const monthCell = fila.querySelector('td:first-child').textContent.toLowerCase();

                        if (monthCell.includes(mesNombre)) {
                            fila.style.display = ''; // Mostrar fila
                            filteredData.push(parseInt(fila.children[1].textContent));
                            filteredLabels.push(monthCell);
                            found = true;
                        } else {
                            fila.style.display = 'none'; // Ocultar fila
                        }
                    });
                } else {
                    // Búsqueda por texto
                    filas.forEach(fila => {
                        const monthCell = fila.querySelector('td:first-child').textContent.toLowerCase();
                        if (monthCell.includes(searchTerm)) {
                            fila.style.display = ''; // Mostrar fila
                            filteredData.push(parseInt(fila.children[1].textContent));
                            filteredLabels.push(monthCell);
                            found = true;
                        } else {
                            fila.style.display = 'none'; // Ocultar fila
                        }
                    });
                }

                if (found) {
                    document.getElementById(`no-result-${chart.form_id}`).style.display = 'none';
                    chartInstance.data.labels = filteredLabels;
                    chartInstance.data.datasets[0].data = filteredData;
                    chartInstance.update();
                } else {
                    document.getElementById(`no-result-${chart.form_id}`).style.display = 'block';
                }
            });
        });
    });
</!--script-->
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
  
              document.querySelector(`#search-${chart.form_id}`).addEventListener('input', function () {
                  const searchTerm = this.value.trim();
                  const tablaId = `table-${chart.form_id}`;
                  const filas = document.querySelectorAll(`#${tablaId} tbody tr`);
                  let filteredData = [];
                  let filteredLabels = [];
                  let found = false;
  
                  // Detectar múltiples fechas separadas por coma
                  const fechas = searchTerm.split(',').map(fecha => fecha.trim());
                  const rangoFechas = [];
  
                  fechas.forEach(fecha => {
                      const regexFecha = /^(\d{2})([-\/\s]?)(\d{2})\2?(\d{2,4})?$/; // Formatos DDMMYY, DD-MM-YY, DD/MM/YY
                      const matchFecha = fecha.match(regexFecha);
  
                      if (matchFecha) {
                          const dia = matchFecha[1];
                          const mes = matchFecha[3];
                          const anio = matchFecha[4] || new Date().getFullYear().toString().slice(-2); // Año actual si no está presente
                          const fechaObj = new Date(`20${anio}`, mes - 1, dia);
                          rangoFechas.push(fechaObj);
                      }
                  });
  
                  if (rangoFechas.length === 2) {
                      const inicio = rangoFechas[0] < rangoFechas[1] ? rangoFechas[0] : rangoFechas[1];
                      const fin = rangoFechas[0] > rangoFechas[1] ? rangoFechas[0] : rangoFechas[1];
  
                      filas.forEach(fila => {
                          const mesNombre = fila.querySelector('td:first-child').textContent.toLowerCase();
                          const mesFecha = new Date(Date.parse(mesNombre + " 1, 2000"));
  
                          if (mesFecha >= inicio && mesFecha <= fin) {
                              fila.style.display = ''; // Mostrar fila
                              filteredData.push(parseInt(fila.children[1].textContent));
                              filteredLabels.push(mesNombre);
                              found = true;
                          } else {
                              fila.style.display = 'none'; // Ocultar fila
                          }
                      });
                  } else if (rangoFechas.length === 1) {
                      // Si solo hay una fecha o búsqueda por texto
                      const fechaUnica = rangoFechas[0];
                      const mesNombre = fechaUnica.toLocaleString('es-ES', { month: 'long' }).toLowerCase();
  
                      filas.forEach(fila => {
                          const monthCell = fila.querySelector('td:first-child').textContent.toLowerCase();
                          if (monthCell.includes(mesNombre)) {
                              fila.style.display = ''; // Mostrar fila
                              filteredData.push(parseInt(fila.children[1].textContent));
                              filteredLabels.push(monthCell);
                              found = true;
                          } else {
                              fila.style.display = 'none'; // Ocultar fila
                          }
                      });
                  } else {
                      filas.forEach(fila => {
                          fila.style.display = 'none'; // Ocultar fila
                      });
                  }
  
                  if (found) {
                      document.getElementById(`no-result-${chart.form_id}`).style.display = 'none';
                      chartInstance.data.labels = filteredLabels;
                      chartInstance.data.datasets[0].data = filteredData;
                      chartInstance.update();
                  } else {
                      document.getElementById(`no-result-${chart.form_id}`).style.display = 'block';
                  }
              });
          });
      });
  </script>
<script>
    // Descargar Excel y PDF
    document.querySelectorAll('.download-excel').forEach(button => {
        button.addEventListener('click', function () {
            const tableId = this.dataset.table;
            const tabla = document.getElementById(tableId);
            const formName = tabla.closest('.graphicblock').querySelector('h6').textContent.split(": ")[1].split('|')[0].trim();
            const wb = XLSX.utils.table_to_book(tabla, { sheet: "Datos" });
            XLSX.writeFile(wb, `${formName.replace(/\s+/g, '_')}_datos.xlsx`);
        });
    });

    document.querySelectorAll('.download-pdf').forEach(button => {
        button.addEventListener('click', function () {
            const tableId = this.dataset.table;
            const tabla = document.getElementById(tableId);
            const formName = tabla.closest('.graphicblock').querySelector('h6').textContent.split(": ")[1].split('|')[0].trim();
            const canvasId = `chart-${tableId.split('-')[1]}`;
            const canvas = document.getElementById(canvasId);
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('landscape');

            doc.setFontSize(16);
            doc.text(`Formulario: ${formName}`, 148, 20, { align: 'center' });

            const imgData = canvas.toDataURL('image/png');
            const imgWidth = 180;
            const imgHeight = (canvas.height * imgWidth) / canvas.width;
            const xPos = (doc.internal.pageSize.getWidth() - imgWidth) / 2;
            const yPos = 30;
            doc.addImage(imgData, 'PNG', xPos, yPos, imgWidth, imgHeight);

            const yStart = yPos + imgHeight + 10;
            const columnHeaders = [];
            const rowData = [];

            tabla.querySelectorAll('thead th').forEach(th => columnHeaders.push(th.textContent));

            tabla.querySelectorAll('tbody tr').forEach(row => {
                const rowContent = [];
                row.querySelectorAll('td').forEach(td => rowContent.push(td.textContent));
                rowData.push(rowContent);
            });

            doc.autoTable({
                startY: yStart,
                head: [columnHeaders],
                body: rowData,
                styles: { halign: 'center', valign: 'middle' },
                theme: 'grid',
            });

            doc.save(`${formName.replace(/\s+/g, '_')}_datos.pdf`);
        });
    });

</script>
<script>
// Exportar grafico a PNG
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
            console.error(`No se encontrÃƒÂ³ el canvas con ID: chart-${formId}`);
        }
    });
});
</script>

@endpush