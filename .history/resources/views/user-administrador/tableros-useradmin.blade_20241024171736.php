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

                         <!-- Selector de tipo de filtro -->
    <div class="form-group">
      <label for="tipoFiltro">Seleccionar Filtro:</label>
      <select id="tipoFiltro" class="form-control">
          <option value="dia">Día</option>
          <option value="rango">Rango de Fechas</option>
      </select>
  </div>

  <!-- Input para seleccionar un día -->
  <div class="form-group" id="inputDia">
      <label for="fechaDia">Seleccionar Día:</label>
      <input type="text" id="fechaDia" class="form-control datepicker" placeholder="Seleccionar Día">
  </div>

  <!-- Input para seleccionar un rango de fechas -->
  <div class="form-group" id="inputRango" style="display:none;">
      <label for="fechaRango">Seleccionar Rango de Fechas:</label>
      <input type="text" id="fechaRango" class="form-control datepicker-range" placeholder="Seleccionar Rango">
  </div>

  <!-- Botón para aplicar los filtros -->
  <div class="form-group">
      <button id="mostrarInfo" class="btn btn-primary">Mostrar Información</button>
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

var data3 = @json($lista3);  // Datos de edades filtrados desde el controlador

const groups = data3.reduce((agg, curr) => {
    let age = curr.edad;
    if (agg[age]) {
        agg[age] += 1;
    } else {
        agg[age] = 1;
    }
    return agg;
}, {});

var options3 = {
    series: Object.values(groups),  // Número de registros por edad
    chart: {
        width: 550,
        type: 'pie',  // Gráfico de torta
    },
    labels: Object.keys(groups),  // Edades como etiquetas
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

var chart3 = new ApexCharts(document.querySelector("#graficaEdad"), options3);
chart3.render();
});

</script>
@endpush
