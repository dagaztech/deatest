@extends('layouts.main')
@section('title', __('Tableros de Uso e Instalación de DEA'))
@section('content') <!-- Aquí comienza la sección de contenido -->

<div class="section-body normal-width">
  <div class="mx-0 mt-5 row">
    <div class="mx-auto col-md-12 rounded-card">
      <div class="tableros-wrapper">
        <div class="card" id="purple-btn">
          <div class="card-header">
            <h5 class="text-center w-100" id="new-title">Tableros de Uso e Instalación de DEA</h5>
          </div>
          <div class="card-body form-card-body">
            
            <!-- Formulario de filtro -->
            <form id="filtro-form">

                <select id="selectorTipoFecha" class="form-select w-33">
                    <option value="dia">Por Día</option>
                    <option value="rango">Por Rango</option>
                  </select>
                    <input type="text" class="form-control mr-1 flatpickr-input  w-33" id="single" name="single" placeholder="Fecha específica" style="display:block;">
                    <input type="text" class="form-control mr-1 flatpickr-input  w-33" id="rango" name="rango" placeholder="Rango de fechas" style="display:none;">
       
                <button type="button" id="filtro-btn" class="btn btn-primary w-33">Filtrar</button>
            </form>
            
            <div class="btns-vertical-wrapper">
              <div class="row">
                <h3>USO DEL DEA</h3>
                <div id="grafico1" style="height: 400px;"></div>
                <hr>
                <h3>INSTALACIÓN DEL DEA</h3>
                <div id="grafico2" style="height: 400px;"></div>
                <hr>
                <h3>USO DE EDAD PROMEDIO</h3>
                <div id="grafico3" style="height: 400px;"></div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection <!-- Aquí finaliza la sección de contenido -->

@push('scripts') <!-- Corregido el nombre a 'scripts' -->

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

  // Mostrar/ocultar campos segÃºn el tipo de filtro seleccionado
  $('#selectorTipoFecha').change(function() {
    var tipo = $(this).val();
    if (tipo === 'dia') {
      $('#single').show();
      $('#rango').hide();
    } else if (tipo === 'rango') {
      $('#single').hide();
      $('#rango').show();
    }
  });

  // Inicializar los inputs de fecha con Flatpickr
  $('#single').flatpickr({ mode: "single", dateFormat: "Y-m-d" });
  $('#rango').flatpickr({ mode: "range", dateFormat: "Y-m-d" });
  
  // Datos iniciales de PHP usando la sintaxis Blade para pasar variables desde el controlador
  var lista = @json($lista);
  var lista2 = @json($lista2);
  var lista3 = @json($lista3);

  // Gráfico 1 - Datos de 'lista' (barras)
  var options1 = {
      chart: {
          type: 'bar'
      },
      series: [{
          name: 'Meses',
          data: lista.map(item => parseInt(item.mes)) // Datos de los meses
      }],
      xaxis: {
          categories: lista.map(item => item.mes) // Categorías (nombres de los meses)
      }
  };
  var chart1 = new ApexCharts(document.querySelector("#grafico1"), options1);
  chart1.render();

  // Gráfico 2 - Datos de 'lista2' (líneas)
  var options2 = {
      chart: {
          type: 'line'
      },
      series: [{
          name: 'Cantidad',
          data: lista2.map(item => parseInt(item.cantidad)) // Datos de la cantidad
      }],
      xaxis: {
          categories: lista2.map(item => item.mes) // Categorías (nombres de los meses)
      }
  };
  var chart2 = new ApexCharts(document.querySelector("#grafico2"), options2);
  chart2.render();

  // Gráfico 3 - Datos de 'lista3' (torta)
  var options3 = {
      chart: {
          type: 'pie'
      },
      series: lista3.map(item => parseInt(item.edad)), // Datos de las edades
      labels: lista3.map(item => item.edad) // Etiquetas (nombres de las edades)
  };
  var chart3 = new ApexCharts(document.querySelector("#grafico3"), options3);
  chart3.render();

  // Función de filtro con AJAX
  $('#filtro-btn').on('click', function() {
      var single = $('#single').val();
      var rango = $('#rango').val();

      $.ajax({
          url: "{{ url('user-administrador/tableros-useradmin') }}", 
          method: 'GET',
          data: {
              single: single,
              rango: rango
          },
          success: function(response) {
              // Actualizar Gráfico 1
              chart1.updateSeries([{
                  data: response.lista.map(item => parseInt(item.mes))
              }]);

              // Actualizar Gráfico 2
              chart2.updateSeries([{
                  data: response.lista2.map(item => parseInt(item.cantidad))
              }]);

              // Actualizar Gráfico 3
              chart3.updateSeries(response.lista3.map(item => parseInt(item.edad)));
          },
          error: function(xhr) {
              console.log(xhr.responseText);
          }
      });
  });
});
</script>
@endpush
