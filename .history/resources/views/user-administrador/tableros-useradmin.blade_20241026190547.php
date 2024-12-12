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
                        <form id="formFiltros">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-start col-sm-4">
                                    <div>
                                        <select id="selectorTipoFecha">
                                            <option value="mes">Por Mes</option>
                                            <option value="dia">Por Día</option>
                                            <option value="rango">Por Rango</option>
                                        </select>
                                        <input id="inputFechaUnica" type="text" placeholder="Seleccionar día" style="display:none;">
                                        <input id="inputRangoFechas" type="text" placeholder="Seleccionar rango" style="display:none;">
                                        <button type="button" id="mostrarResultados">Mostrar información</button>
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
<script src="{{ asset('vendor/apex-chart/apexcharts.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // Datos de ejemplo (debes reemplazarlos con los datos reales)
        var data = @json($lista);
        var data2 = @json($lista2);
        var data3 = @json($lista3);

        function generarGraficos(filtro = null) {
            // Filtrar datos si se aplica un filtro
            if (filtro) {
                // Implementar la lógica de filtrado aquí
                // Por ejemplo: filtrar por mes, día o rango de fechas
            }

            var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            // Gráfico de uso del DEA (barras)
            var seriesUso = Array(12).fill(0);
            data.forEach(d => {
                var mesIndex = parseInt(d.mes) - 1; // Suponiendo que mes está en formato numérico (1-12)
                seriesUso[mesIndex] += 1;
            });

            var opcionesUso = {
                series: [{ name: 'Uso del DEA', data: seriesUso }],
                chart: { type: 'bar', height: 350 },
                xaxis: { categories: meses },
                yaxis: { title: { text: "Número de Registros" } }
            };
            var chartUso = new ApexCharts(document.querySelector("#graficaUso"), opcionesUso);
            chartUso.render();

            // Gráfico de instalación del DEA (puntos)
            var seriesInstalacion = Array(12).fill(0);
            data2.forEach(d => {
                var mesIndex = parseInt(d.mes) - 1; // Suponiendo que mes está en formato numérico (1-12)
                seriesInstalacion[mesIndex] += parseInt(d.cantidad);
            });

            var opcionesInstalacion = {
                series: [{ name: 'Instalación del DEA', data: seriesInstalacion }],
                chart: { type: 'line', height: 350 },
                xaxis: { categories: meses },
                markers: {size: 0,},
                yaxis: { title: { text: "Número de Registros" } }
            };
            var chartInstalacion = new ApexCharts(document.querySelector("#graficaInstalacion"), opcionesInstalacion);
            chartInstalacion.render();

            // Gráfico de uso de edad promedio (torta)
            var seriesEdad = {};
            data3.forEach(d => {
                seriesEdad[d.edad] = (seriesEdad[d.edad] || 0) + 1;
            });

            var opcionesEdad = {
                series: Object.values(seriesEdad),
                chart: { type: 'pie', width: 550 },
                labels: Object.keys(seriesEdad),
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: { width: 500 },
                        legend: { position: 'bottom' }
                    }
                }]
            };
            var chartEdad = new ApexCharts(document.querySelector("#graficaEdad"), opcionesEdad);
            chartEdad.render();
        }

        // Generar gráficos al cargar la página
        generarGraficos();

        // Evento para el botón "Mostrar información"
        $('#mostrarResultados').on('click', function() {
            var tipoFecha = $('#selectorTipoFecha').val();
            var filtro = {};

            if (tipoFecha === 'mes') {
                filtro.tipo = 'mes';
                filtro.mes = $('#inputFechaUnica').val();
            } else if (tipoFecha === 'dia') {
                filtro.tipo = 'dia';
                filtro.dia = $('#inputFechaUnica').val();
            } else if (tipoFecha === 'rango') {
                filtro.tipo = 'rango';
                filtro.rango = $('#inputRangoFechas').val();
            }

            // Aquí deberías implementar la lógica para filtrar los datos y volver a generar los gráficos
            generarGraficos(filtro);
        });

        // Muestra el campo correspondiente al tipo de filtro seleccionado
        $('#selectorTipoFecha').change(function() {
            var tipo = $(this).val();
            $('#inputFechaUnica, #inputRangoFechas').hide();

            if (tipo === 'dia') $('#inputFechaUnica').show();
            else if (tipo === 'rango') $('#inputRangoFechas').show();
        });

        // Inicializa los selectores de fecha
        $('#inputFechaUnica').flatpickr({ dateFormat: "Y-m-d" });
        $('#inputRangoFechas').flatpickr({ mode: "range", dateFormat: "Y-m-d" });
    });
</script>
@endpush

