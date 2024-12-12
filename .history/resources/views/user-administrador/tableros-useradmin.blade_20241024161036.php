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

                            <!-- Filtro por Día, Mes y Año -->
                            <div>
                              <label for="filter-type">Filtrar por:</label>
                              <select id="filter-type">
                                  <option value="dia">Día</option>
                                  <option value="mes">Mes</option>
                                  <option value="rango">Rango de Fechas</option>
                              </select>
                          </div>
                          
                          <!-- Input para filtrar por día -->
                          <div id="dia-filter" style="display:block;">
                              <input id="pc-daterangepicker-dia" placeholder="Selecciona un día" />
                          </div>
                          
                          <!-- Input para filtrar por mes -->
                          <div id="mes-filter" style="display:none;">
                              <input id="pc-daterangepicker-mes" placeholder="Selecciona un mes" />
                          </div>
                          
                          <!-- Input para filtrar por rango de fechas -->
                          <div id="rango-filter" style="display:none;">
                              <input id="pc-daterangepicker-rango" placeholder="Selecciona un rango de fechas" />
                          </div>

                          </div>
            
                          <div id="graficaUso"></div>
                          <div id="graficaInstalacion"></div>
                          <div id="graficaEdad"></div>
            
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
$(document).ready(function () {
    // Lógica para mostrar los inputs según la selección
    $('#filter-type').change(function () {
        const selectedFilter = $(this).val();

        // Ocultar todos los inputs
        $('#dia-filter').hide();
        $('#mes-filter').hide();
        $('#rango-filter').hide();

        // Mostrar el input correspondiente al filtro seleccionado
        if (selectedFilter === 'dia') {
            $('#dia-filter').show();
        } else if (selectedFilter === 'mes') {
            $('#mes-filter').show();
        } else if (selectedFilter === 'rango') {
            $('#rango-filter').show();
        }
    });

    // Flatpickr para seleccionar día
    $('#pc-daterangepicker-dia').flatpickr({
        mode: 'single',
        dateFormat: 'Y-m-d',
        maxDate: 'today',
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
    });

    // Flatpickr para seleccionar mes
    $('#pc-daterangepicker-mes').flatpickr({
        plugins: [
            new monthSelectPlugin({
                shorthand: true,
                dateFormat: "Y-m",
                altFormat: "F Y",
            })
        ],
        maxDate: 'today',
    });

    // Flatpickr para seleccionar rango de fechas
    $('#pc-daterangepicker-rango').flatpickr({
        mode: 'range',
        dateFormat: 'Y-m-d',
        maxDate: 'today',
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
    });

    // Lógica para actualizar gráficos según la selección de filtro
    function actualizarGraficos(fechaSeleccionada) {
        $.ajax({
            url: '/ruta-al-controlador',  // Ajusta la ruta al controlador que maneja los datos
            method: 'GET',
            data: {
                filtro: $('#filter-type').val(),
                fecha: fechaSeleccionada,
            },
            success: function (response) {
                // Asumiendo que response contiene los datos necesarios para los gráficos
                actualizarGraficaUso(response.dataUso);
                actualizarGraficaInstalacion(response.dataInstalacion);
                actualizarGraficaEdad(response.dataEdad);
            }
        });
    }

    // Funciones para renderizar gráficos con ApexCharts
    function actualizarGraficaUso(data) {
        const options = {
            series: [{
                data: data
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            xaxis: {
                categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            }
        };
        const chart = new ApexCharts(document.querySelector("#graficaUso"), options);
        chart.render();
    }

    function actualizarGraficaInstalacion(data) {
        const options = {
            series: [{
                data: data
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: true,
                }
            },
            xaxis: {
                categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            }
        };
        const chart = new ApexCharts(document.querySelector("#graficaInstalacion"), options);
        chart.render();
    }

    function actualizarGraficaEdad(data) {
        const options = {
            series: data,
            chart: {
                type: 'pie',
                width: 550,
            },
            labels: Object.keys(data),
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
        const chart = new ApexCharts(document.querySelector("#graficaEdad"), options);
        chart.render();
    }

    // Escuchar cambios en los inputs y actualizar gráficos
    $('#pc-daterangepicker-dia, #pc-daterangepicker-mes, #pc-daterangepicker-rango').change(function () {
        const fechaSeleccionada = $(this).val();
        actualizarGraficos(fechaSeleccionada);
    });
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
