@extends('layouts.main')
@section('title', __('Tableros de Uso e Instalación de DEA'))


<div class="section-body normal-width">
  <div class="mx-0 mt-5 row">
      <div class="mx-auto col-md-12 rounded-card">
          <div class="tableros-wrapper">
              <div class="card" id="purple-btn">
                  <div class="card-header">
                      <h5 class="text-center w-100" id="new-title">Tableros de Uso e Instalación de DEA</h5>
                  </div>
                  <div class="card-body form-card-body">
                      <form method="post" action="{{ url('user-administrador/tableros-useradmin') }}">
                          @csrf
                          <div class="row">
                              <div class="form-group d-flex justify-content-start col-sm-4">
                                  <div class="filterswrap">
                                      <select id="selectorTipoFecha" class="form-select w-33">
                                          <option value="dia">Por Día</option>
                                          <option value="rango">Por Rango</option>
                                      </select>
                                      <input id="inputFechaUnica" type="text" placeholder="Seleccionar día" style="display:block;">
                                      <input id="inputRangoFechas" type="text" placeholder="Seleccionar rango" style="display:none;">
                                      <button class="btn btn-primary" type="button" id="mostrarResultados">Mostrar información</button>
                                  </div>
                              </div>
                          </div>
                      </form>
                      <div class="btns-vertical-wrapper">
                          <div class="row">
                              <h3>USO DEL DEA</h3>
                              <div id="graficaUso"></div>
                              <hr>
                              <h3>INSTALACIÓN DEL DEA</h3>
                              <div id="graficaInstalacion"></div>
                              <hr>
                              <h3>USO DE EDAD PROMEDIO</h3>
                              <div id="graficaEdad"></div>
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
              <div class="logos_footer_gov"><a href="https://www.colombia.co" target="_blank"><img class="marcaco_l" src="../../images/logo.png" alt="colombia.co"></a></div>
              <div class="alcaldia_mod_footer"><a href="https://www.medellin.gov.co/es"><img class="log_nww_footer" src="../../images/logo_nav_footer.png" alt="Alcaldía de Medellín"></a></div>
          </div>
      </div>
  </div>
</div>

@push('script')
<style>
  .filterswrap{
    width: 100%;
    float: left;
}
.w-33{
    width: 31%;
    float: left;
    display:inline-block;
    margin:0 1%;
}
</style>
<script src="{{ asset('vendor/apex-chart/apexcharts.min.js') }}"></script>
<script>
  $(document).ready(function() {

   
        var data = @json($lista);
        var data2 = @json($lista2);
        var data3 = @json($lista3);
      /*var data = [];
      var data2 = [];
      var data3 = [];*/
      
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

      // Función que genera los gráficos
      function generarGraficos() {
          // Gráfico de Uso del DEA
          var opcionesUso = {
              series: [{
                  name: 'Uso del DEA',
                  data: [
                      data.filter(x => x == "01").length,
                      data.filter(x => x == "02").length,
                      data.filter(x => x == "03").length,
                      data.filter(x => x == "04").length,
                      data.filter(x => x == "05").length,
                      data.filter(x => x == "06").length,
                      data.filter(x => x == "07").length,
                      data.filter(x => x == "08").length,
                      data.filter(x => x == "09").length,
                      data.filter(x => x == "10").length,
                      data.filter(x => x == "11").length,
                      data.filter(x => x == "12").length,
                  ]
              }],
              chart: {
                  type: 'line',
                  height: 350
              },
              xaxis: {
                  categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
              },
              yaxis: { title: { text: "Número de Registros" } }
          };

          var chartUso = new ApexCharts(document.querySelector("#graficaUso"), opcionesUso);
          chartUso.render();

          // Gráfico de Instalación del DEA
          var opcionesInstalacion = {
              series: [{
                  name: 'Instalación del DEA',
                  data: [
                      data2.filter(x => x.mes == "01").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "02").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "03").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "04").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "05").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "06").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "07").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "08").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "09").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "10").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "11").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "12").reduce((sum, a) => sum + +a.cantidad, 0),
                  ]
              }],
              chart: {
                  type: 'line',
                  height: 350
              },
              xaxis: {
                  categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
              },
              yaxis: { title: { text: "Número de Registros" } }
          };

          var chartInstalacion = new ApexCharts(document.querySelector("#graficaInstalacion"), opcionesInstalacion);
          chartInstalacion.render();

          // Gráfico de Edad Promedio
          var opcionesEdad = {
              series: Object.values(groups),
              chart: {
                  width: 550,
                  type: 'pie',
              },
              labels: Object.keys(groups),
              responsive: [{
                  breakpoint: 480,
                  options: {
                      chart: {
                          width: 500
                      },
                      legend: {
                          position: 'bottom'
                      }
                  }
              }]
          };

          var chartEdad = new ApexCharts(document.querySelector("#graficaEdad"), opcionesEdad);
          chartEdad.render();

          
      }
  // Generar gráficos al cargar la página
  generarGraficos();

      // Evento para el botón "Mostrar información"
      $('#mostrarResultados').on('click', function(e) {
          e.preventDefault();
          // Evitar recargar la página
          generarGraficos();
      });
  });
</script>

<script>
  $(document).ready(function() {
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