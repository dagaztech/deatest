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

  // Evento del botón para mostrar información
  $('#mostrarResultados').on('click', function() {
    var tipoFecha = $('#selectorTipoFecha').val();
    var fecha = tipoFecha === 'dia' ? $('#inputFechaUnica').val() : $('#inputRangoFechas').val();
    
    // Enviar la solicitud AJAX
    $.ajax({
      url: "{{ url('user-administrador/tableros-useradmin') }}",
      method: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        single: tipoFecha === 'dia' ? fecha : null,
        rango: tipoFecha === 'rango' ? fecha : null,
      },
      success: function(response) {
        // Actualizar gráficos con los nuevos datos
        actualizarGraficos(response.lista, response.lista2, response.lista3);
      },
      error: function() {
        alert("Error al consultar los datos");
      }
    });
  });

  // Función para actualizar los gráficos
  function actualizarGraficos(data, data2, data3) {
    // Gráfico de Uso del DEA
    var opcionesUso = {
      series: [{ name: 'Uso del DEA', data: contarPorMes(data) }],
      chart: { type: 'line', height: 350 },
      xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] },
      yaxis: { title: { text: "Número de Registros" } }
    };
    new ApexCharts(document.querySelector("#graficaUso"), opcionesUso).render();

    // Gráfico de Instalación del DEA
    var opcionesInstalacion = {
      series: [{ name: 'Instalación del DEA', data: contarInstalacionesPorMes(data2) }],
      chart: { type: 'line', height: 350 },
      xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] },
      yaxis: { title: { text: "Número de Registros" } }
    };
    new ApexCharts(document.querySelector("#graficaInstalacion"), opcionesInstalacion).render();

    // Gráfico de Edad Promedio
    var gruposEdad = agruparPorEdad(data3);
    var opcionesEdad = {
      series: gruposEdad,
      chart: { type: 'pie', height: 350 },
      labels: ['<20', '20-30', '31-40', '41-50', '51-60', '61-70', '>70'],
      title: { text: "Distribución por Edad" }
    };
    new ApexCharts(document.querySelector("#graficaEdad"), opcionesEdad).render();
  }

  // Funciones auxiliares para procesar los datos
  function contarPorMes(data) {
    var cuenta = new Array(12).fill(0);
    data.forEach(item => {
      cuenta[parseInt(item.mes) - 1]++;
    });
    return cuenta;
  }

  function contarInstalacionesPorMes(data2) {
    var cuenta = new Array(12).fill(0);
    data2.forEach(item => {
      cuenta[parseInt(item.mes) - 1] += parseInt(item.cantidad);
    });
    return cuenta;
  }

  function agruparPorEdad(data3) {
    var grupos = [0, 0, 0, 0, 0, 0, 0];
    data3.forEach(item => {
      var edad = parseInt(item.edad);
      if (edad < 20) grupos[0]++;
      else if (edad >= 20 && edad <= 30) grupos[1]++;
      else if (edad >= 31 && edad <= 40) grupos[2]++;
      else if (edad >= 41 && edad <= 50) grupos[3]++;
      else if (edad >= 51 && edad <= 60) grupos[4]++;
      else if (edad >= 61 && edad <= 70) grupos[5]++;
      else grupos[6]++;
    });
    return [{ name: 'Edades', data: grupos }];
  }
});
</script>
@endpush
