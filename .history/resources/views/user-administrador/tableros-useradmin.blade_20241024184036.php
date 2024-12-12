@extends('layouts.main')
@section('title', __('Tableros de Uso e Instalación de DEA'))


<div class="section-body normal-width">

    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
          <div class="tableros-wrapper">
                <div class="card"  id="purple-btn">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Tableros de Uso e Instalación de DEA</h5>
                    </div>
                    <div class="card-body form-card-body">
                    
                      <form method="post" action="{{ url('user-administrador/tableros-useradmin') }}">
                        @csrf 
            
                        <div class="row">
                        <div class="form-group d-flex justify-content-start col-sm-4">

                          <!-- Selectores para fecha y rango -->
                          <div>
                              <select id="selectorTipoFecha">
                                  <option value="dia">Por Día</option>
                                  <option value="rango">Por Rango</option>
                              </select>

                              <!-- Input para seleccionar fecha única -->
                              <input id="inputFechaUnica" type="text" placeholder="Seleccionar día" style="display:block;">

                              <!-- Input para seleccionar rango de fechas -->
                              <input id="inputRangoFechas" type="text" placeholder="Seleccionar rango" style="display:none;">

                              <!-- Botón para mostrar los gráficos -->
                              <button type="button" id="mostrarResultados">Mostrar información</button>
                          </div>

                        </div>
            
                    </form>
                      <div class="btns-vertical-wrapper">
                        <div class="row">
                          <h3>USO DEL DEA</h3>

                            <div id="graficaUso">
                            </div>

                          <hr>
                          <h3>INSTALACIÓN DEL DEA</h3>

                            <div id="graficaInstalacion">
                            </div>
                          <hr>
                          <h3>USO DE EDAD PROMEDIO</h3>

                            <div id="graficaEdad">
                            </div>
                        </div></div>
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
              <div class="alcaldia_mod_footer"><a href="https://www.medellin.gov.co/es"><img  class="log_nww_footer" src="../../images/logo_nav_footer.png" alt="Alcaldía de Medellín"></a></div>
           </div>
        </div>
     </div>
</div>

@push('script')
<script src="{{ asset('vendor/apex-chart/apexcharts.min.js') }}"></script>

<script>
  $(document).ready(function() {
      // Variables para los datos originales
      var data = [];
      var data2 = [];
      var data3 = [];
  
      @foreach ($lista as $item)
      var fecha = '{{ $item["fecha"] }}'; // Usamos la fecha completa
      data.push(fecha);
      @endforeach
  
      @foreach ($lista2 as $item)
      var fecha = '{{ $item["fecha"] }}'; // Usamos la fecha completa
      var cant = '{{ $item["cantidad"] }}';
      data2.push({ fecha: fecha, cantidad: cant });
      @endforeach
  
      @foreach ($lista3 as $item)
      var edad = '{{ $item["edad"] }}';
      data3.push(edad);
      @endforeach
  
      const groups = data3.reduce((agg, curr) => {
          agg[curr] = (agg[curr] || 0) + 1;
          return agg;
      }, {});
  
      // Función que genera los gráficos con datos filtrados
      function generarGraficos(filtroInicio = null, filtroFin = null) {
          var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  
          var dataFiltrada = data;
          var data2Filtrada = data2;
  
          // Filtrar por fechas completas si se selecciona un filtro
          if (filtroInicio && filtroFin) {
              dataFiltrada = data.filter(fecha => new Date(fecha) >= new Date(filtroInicio) && new Date(fecha) <= new Date(filtroFin));
              data2Filtrada = data2.filter(item => new Date(item.fecha) >= new Date(filtroInicio) && new Date(item.fecha) <= new Date(filtroFin));
          } else if (filtroInicio) {
              dataFiltrada = data.filter(fecha => new Date(fecha).toDateString() == new Date(filtroInicio).toDateString());
              data2Filtrada = data2.filter(item => new Date(item.fecha).toDateString() == new Date(filtroInicio).toDateString());
          }
  
          // Generar series para los gráficos, manteniendo las categorías visibles con 0 si no hay datos
          var seriesUso = meses.map((mes, index) => {
              var mesIndex = ("0" + (index + 1)).slice(-2); // Convertir el índice al formato "01", "02", etc.
              return dataFiltrada.filter(x => new Date(x).getMonth() == index).length; 
          });
  
          var seriesInstalacion = meses.map((mes, index) => {
              var mesIndex = ("0" + (index + 1)).slice(-2);
              return data2Filtrada.filter(x => new Date(x.fecha).getMonth() == index).reduce((sum, a) => sum + +a.cantidad, 0);
          });
  
          // Si no hay datos filtrados, mostrar las gráficas con valor 0 en los meses sin datos
          var options = {
              series: [{ data: seriesUso }],
              chart: { type: 'bar', height: 350 },
              plotOptions: { bar: { borderRadius: 4, horizontal: true } },
              xaxis: { categories: meses }
          };
  
          var chart = new ApexCharts(document.querySelector("#graficaUso"), options);
          chart.render();
  
          var options2 = {
              series: [{ data: seriesInstalacion }],
              chart: { type: 'bar', height: 350 },
              plotOptions: { bar: { borderRadius: 4, horizontal: true } },
              xaxis: { categories: meses }
          };
  
          var chart2 = new ApexCharts(document.querySelector("#graficaInstalacion"), options2);
          chart2.render();
  
          var options3 = {
              series: Object.values(groups),
              chart: { width: 550, type: 'pie' },
              labels: Object.keys(groups),
              responsive: [{ breakpoint: 480, options: { chart: { width: 500 }, legend: { position: 'bottom' } } }]
          };
  
          var chart3 = new ApexCharts(document.querySelector("#graficaEdad"), options3);
          chart3.render();
      }
  
      // Generar gráficos con todos los datos al cargar la página
      generarGraficos();
  
      // Evento para el botón "Mostrar información"
      $('#mostrarResultados').on('click', function(e) {
          e.preventDefault(); // Evitar recargar la página
  
          // Obtener el tipo de filtro seleccionado
          var tipo = $('#selectorTipoFecha').val();
          var fechaInicio = null;
          var fechaFin = null;
  
          if (tipo === 'dia') {
              fechaInicio = $('#inputFechaUnica').val();
          } else if (tipo === 'rango') {
              var rango = $('#inputRangoFechas').val().split(' to ');
              fechaInicio = rango[0];
              fechaFin = rango[1];
          }
  
          // Limpiar los gráficos anteriores
          $("#graficaUso").html('');
          $("#graficaInstalacion").html('');
          $("#graficaEdad").html('');
  
          // Generar gráficos con el filtro aplicado
          generarGraficos(fechaInicio, fechaFin);
      });
  
      // Controlar la visualización de los inputs de fecha
      $('#selectorTipoFecha').change(function() {
          var tipo = $(this).val();
          if (tipo === 'dia') {
              $('#inputFechaUnica').show();
              $('#inputRangoFechas').hide();
          } else if (tipo === 'rango') {
              $('#inputFechaUnica').hide();
              $('#inputRangoFechas').show();
          }
      });
  
      // Flatpickr para las fechas
      $('#inputFechaUnica').flatpickr({ mode: "single", dateFormat: "Y-m-d" });
      $('#inputRangoFechas').flatpickr({ mode: "range", dateFormat: "Y-m-d" });
  });
  </script>
  
@endpush
