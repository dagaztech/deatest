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
      var mes = '{{ $item["mes"] }}';
      data.push(mes);
      @endforeach
  
      @foreach ($lista2 as $item)
      var mes = '{{ $item["mes"] }}';
      var cant = '{{ $item["cantidad"] }}';
      data2.push({ mes: mes, cantidad: cant });
      @endforeach
  
      @foreach ($lista3 as $item)
      var edad = '{{ $item["edad"] }}';
      data3.push(edad);
      @endforeach
  
      const groups = data3.reduce((agg, curr) => {
          agg[curr] = (agg[curr] || 0) + 1;
          return agg;
      }, {});
  
      // Configuraciones iniciales de los gráficos
      var chartUso = null;
      var chartInstalacion = null;
      var chartEdad = null;
  
      // Función que genera o actualiza los gráficos
      function generarGraficos(filtroInicio = null, filtroFin = null) {
          var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
  
          var seriesUso = meses.map((mes, index) => {
              var mesIndex = ("0" + (index + 1)).slice(-2);
              if (filtroInicio && filtroFin) {
                  return (mesIndex >= filtroInicio && mesIndex <= filtroFin) ? data.filter(x => x == mesIndex).length : 0;
              } else if (filtroInicio) {
                  return (mesIndex == filtroInicio) ? data.filter(x => x == mesIndex).length : 0;
              } else {
                  return data.filter(x => x == mesIndex).length;
              }
          });
  
          var seriesInstalacion = meses.map((mes, index) => {
              var mesIndex = ("0" + (index + 1)).slice(-2);
              if (filtroInicio && filtroFin) {
                  return (mesIndex >= filtroInicio && mesIndex <= filtroFin) ? data2.filter(x => x.mes == mesIndex).reduce((sum, a) => sum + +a.cantidad, 0) : 0;
              } else if (filtroInicio) {
                  return (mesIndex == filtroInicio) ? data2.filter(x => x.mes == mesIndex).reduce((sum, a) => sum + +a.cantidad, 0) : 0;
              } else {
                  return data2.filter(x => x.mes == mesIndex).reduce((sum, a) => sum + +a.cantidad, 0);
              }
          });
  
          // Configuración de las gráficas
          var optionsUso = {
              series: [{ data: seriesUso }],
              chart: { type: 'bar', height: 350 },
              plotOptions: { bar: { borderRadius: 4, horizontal: true } },
              xaxis: { categories: meses }
          };
  
          var optionsInstalacion = {
              series: [{ data: seriesInstalacion }],
              chart: { type: 'bar', height: 350 },
              plotOptions: { bar: { borderRadius: 4, horizontal: true } },
              xaxis: { categories: meses }
          };
  
          var optionsEdad = {
              series: Object.values(groups),
              chart: { width: 550, type: 'pie' },
              labels: Object.keys(groups),
              responsive: [{ breakpoint: 480, options: { chart: { width: 500 }, legend: { position: 'bottom' } } }]
          };
  
          // Si los gráficos ya están creados, solo actualizamos sus series
          if (chartUso && chartInstalacion && chartEdad) {
              chartUso.updateSeries([{ data: seriesUso }]);
              chartInstalacion.updateSeries([{ data: seriesInstalacion }]);
          } else {
              // Si es la primera vez que se crean, se renderizan
              chartUso = new ApexCharts(document.querySelector("#graficaUso"), optionsUso);
              chartUso.render();
  
              chartInstalacion = new ApexCharts(document.querySelector("#graficaInstalacion"), optionsInstalacion);
              chartInstalacion.render();
  
              chartEdad = new ApexCharts(document.querySelector("#graficaEdad"), optionsEdad);
              chartEdad.render();
          }
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
  
          // Generar gráficos con el filtro aplicado (sin borrar gráficos)
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
