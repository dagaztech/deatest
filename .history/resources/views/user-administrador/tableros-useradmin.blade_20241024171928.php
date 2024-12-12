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

                            <div>
                              <label for="filter-type">Filtrar por:</label>
                              <select id="filter-type">
                                  <option value="dia">Día</option>
                                  <option value="rango">Rango de Fechas</option>
                              </select>
                          </div>
                          
                          <!-- Input para filtrar por día -->
                          <div id="dia-filter" style="display:block;">
                              <input id="pc-daterangepicker-dia" placeholder="Selecciona un día" />
                          </div>
                          
                          <!-- Input para filtrar por rango de fechas -->
                          <div id="rango-filter" style="display:none;">
                              <input id="pc-daterangepicker-rango" placeholder="Selecciona un rango de fechas" />
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
    var data = @json($lista);
    var data2 = @json($lista2);
    var data3 = @json($lista3);

    // Preparar los datos para la gráfica de edades
    const groups = data3.reduce((agg, curr) => {
        if (agg[curr.edad]) {
            agg[curr.edad] += 1;
        } else {
            agg[curr.edad] = 1;
        }
        return agg;
    }, {});

    // Gráfica 1: Uso por mes
    var options1 = {
        series: [{
            data: [
                data.filter(x => x.mes == "01").length,
                data.filter(x => x.mes == "02").length,
                data.filter(x => x.mes == "03").length,
                data.filter(x => x.mes == "04").length,
                data.filter(x => x.mes == "05").length,
                data.filter(x => x.mes == "06").length,
                data.filter(x => x.mes == "07").length,
                data.filter(x => x.mes == "08").length,
                data.filter(x => x.mes == "09").length,
                data.filter(x => x.mes == "10").length,
                data.filter(x => x.mes == "11").length,
                data.filter(x => x.mes == "12").length
            ]
        }],
        chart: { type: 'bar', height: 350 },
        plotOptions: { bar: { borderRadius: 4, horizontal: true } },
        xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"] }
    };

    var chart1 = new ApexCharts(document.querySelector("#graficaUso"), options1);
    chart1.render();

    // Gráfica 2: Cantidad de DEAs por mes
    var options2 = {
        series: [{
            data: [
                data2.filter(x => x.mes == "01").reduce((sum, a) => sum + +a.cantidad, 0),
                data2.filter(x => x.mes == "02").reduce((sum, a) => sum + +a.cantidad, 0),
                data2.filter(x => x.mes == "03").reduce((sum, a) => sum + +a.cantidad, 0),
                // Continúa para los demás meses...
            ]
        }],
        chart: { type: 'bar', height: 350 },
        plotOptions: { bar: { borderRadius: 4, horizontal: true } },
        xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"] }
    };

    var chart2 = new ApexCharts(document.querySelector("#graficaInstalacion"), options2);
    chart2.render();

    // Gráfica 3: Torta de edades
    var options3 = {
        series: Object.values(groups),
        chart: { width: 550, type: 'pie' },
        labels: Object.keys(groups),
        responsive: [{
            breakpoint: 480,
            options: {
                chart: { width: 500 },
                legend: { position: 'bottom' }
            }
        }]
    };

    var chart3 = new ApexCharts(document.querySelector("#graficaEdad"), options3);
    chart3.render();
});

</script>




<style>
  body {
    display: flex;
    width: 100% !important;
    height: auto !important;
    flex-direction: unset !important;
  }
</style>

<!-- PARA FILTRO POR FECHA UNICA-->
<script>
      $(document).ready(function(){
    const isRangeMode = false; // Cambia a false si quieres seleccionar solo una fecha

    document.querySelector("#pc-daterangepicker-1").flatpickr({
        mode: isRangeMode ? "range" : "single", // Si es true, usa rango; si no, una sola fecha
        maxDate: "today",
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
            }, 
            months: {
                shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            },
        },
        dateFormat: "Y-m-d",
        disable: [
            function(date) {
                return !(date.getDate());
            }
        ]
    });
});
</script>

<!-- PARA FILTRO POR FECHA RANGO-->

<script>
  $(document).ready(function(){
const isRangeMode = true; // Cambia a false si quieres seleccionar solo una fecha

document.querySelector("#pc-daterangepicker-2").flatpickr({
    mode: isRangeMode ? "range" : "single", // Si es true, usa rango; si no, una sola fecha
    maxDate: "today",
    locale: {
        firstDayOfWeek: 1,
        weekdays: {
            shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
            longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
        }, 
        months: {
            shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        },
    },
    dateFormat: "Y-m-d",
    disable: [
        function(date) {
            return !(date.getDate());
        }
    ]
});
});

</script>
@endpush
