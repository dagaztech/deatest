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
            <form id="filtroForm">
              @csrf
              <div class="row">
                <div class="form-group d-flex justify-content-start col-sm-12">
                  <div class="filterswrap">
                    <select id="selectorTipoFecha" class="form-select w-33">
                      <option value="dia">Por Día</option>
                      <option value="rango">Por Rango</option>
                    </select>
                    <input id="inputFechaUnica" class="form-control w-33" type="text" placeholder="Seleccionar día" style="display:block;">
                    <input id="inputRangoFechas" class="form-control w-33" type="text" placeholder="Seleccionar rango" style="display:none;">
                    <button class="btn btn-primary w-33" type="button" id="mostrarResultados">Mostrar información</button>
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

                <div id="grafico1"></div>
    <div id="grafico2"></div>
    <div id="grafico3"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('script')
<script>
$(document).ready(function() {
  // Mostrar/ocultar campos según el tipo de filtro seleccionado
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

  // Inicializar Flatpickr
  $('#inputFechaUnica').flatpickr({ mode: "single", dateFormat: "Y-m-d" });
  $('#inputRangoFechas').flatpickr({ mode: "range", dateFormat: "Y-m-d" });


        // Datos de PHP
        var lista = @json($lista);
        var lista2 = @json($lista2);
        var lista3 = @json($lista3);

        // Gráfico 1 - Ejemplo con datos de 'lista'
        var options1 = {
            chart: {
                type: 'bar'
            },
            series: [{
                name: 'Meses',
                data: lista.map(item => parseInt(item.mes)) // Usar el campo "mes"
            }],
            xaxis: {
                categories: lista.map(item => item.mes) // Nombres de los meses
            }
        };
        var chart1 = new ApexCharts(document.querySelector("#grafico1"), options1);
        chart1.render();

        // Gráfico 2 - Ejemplo con datos de 'lista2'
        var options2 = {
            chart: {
                type: 'line'
            },
            series: [{
                name: 'Cantidad',
                data: lista2.map(item => parseInt(item.cantidad)) // Usar el campo "cantidad"
            }],
            xaxis: {
                categories: lista2.map(item => item.mes) // Nombres de los meses
            }
        };
        var chart2 = new ApexCharts(document.querySelector("#grafico2"), options2);
        chart2.render();

        // Gráfico 3 - Ejemplo con datos de 'lista3' (edades)
        var options3 = {
            chart: {
                type: 'pie'
            },
            series: lista3.map(item => parseInt(item.edad)), // Edades
            labels: lista3.map(item => item.edad) // Etiquetas de edades
        };
        var chart3 = new ApexCharts(document.querySelector("#grafico3"), options3);
        chart3.render();
 
});
</script>
@endpush
