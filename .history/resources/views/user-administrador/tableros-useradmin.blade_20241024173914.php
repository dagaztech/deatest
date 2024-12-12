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
            
                         <!--div class="form-group d-flex justify-content-start col-sm-4">
                            <input class="mr-1 form-control " placeholder="Búsqueda"   name="busqueda" type="text" >
                        </div-->
            
                        <div class="form-group d-flex justify-content-start col-sm-4">
                           <!-- <input class="mr-2 form-control created_at flatpickr-input" placeholder="Selecciona por fecha" id="pc-daterangepicker-1" onchange="updateEndDate()" name="single" type="text" readonly="readonly">
                            <input class="mr-2 form-control created_at flatpickr-input" placeholder="Selecciona por rango" id="pc-daterangepicker-2" onchange="updateEndDate()" name="rango" type="text" readonly="readonly">-->

                          <!-- Selectores para fecha y rango -->
<div>
  <select id="selectorTipoFecha">
      <option value="dia">Por Día</option>
      <option value="rango">Por Rango</option>
  </select>

  <!-- Input para seleccionar fecha única -->
  <input id="inputFechaUnica" type="text" placeholder="Seleccionar día" style="display:none;">

  <!-- Input para seleccionar rango de fechas -->
  <input id="inputRangoFechas" type="text" placeholder="Seleccionar rango" style="display:none;">

  <!-- Botón para mostrar los gráficos -->
  <button id="mostrarResultados">Mostrar información</button>
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

      // Función que genera los gráficos
      function generarGraficos() {
          var options = {
              series: [{
                  data: [
                      data.filter(x => x == "01").length,
                      data.filter(x => x == "02").length,
                      data.filter(x => x == "03").length,
                      // y los otros meses...
                  ]
              }],
              chart: { type: 'bar', height: 350 },
              plotOptions: { bar: { borderRadius: 4, horizontal: true } },
              xaxis: { categories: ['Enero', 'Febrero', 'Marzo'] }
          };
          var chart = new ApexCharts(document.querySelector("#graficaUso"), options);
          chart.render();

          var options2 = {
              series: [{
                  data: [
                      data2.filter(x => x.mes == "01").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "02").reduce((sum, a) => sum + +a.cantidad, 0),
                      data2.filter(x => x.mes == "03").reduce((sum, a) => sum + +a.cantidad, 0),
                      // y los otros meses...
                  ]
              }],
              chart: { type: 'bar', height: 350 },
              plotOptions: { bar: { borderRadius: 4, horizontal: true } },
              xaxis: { categories: ['Enero', 'Febrero', 'Marzo'] }
          };
          var chart2 = new ApexCharts(document.querySelector("#graficaInstalacion"), options2);
          chart2.render();

          var options3 = {
              series: Object.values(groups),
              chart: { width: 550, type: 'pie' },
              labels: Object.keys(groups),
              responsive: [{
                  breakpoint: 480,
                  options: { chart: { width: 500 }, legend: { position: 'bottom' } }
              }]
          };
          var chart3 = new ApexCharts(document.querySelector("#graficaEdad"), options3);
          chart3.render();
      }

      // Evento para el botón "Mostrar información"
      $('#mostrarResultados').on('click', function() {
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