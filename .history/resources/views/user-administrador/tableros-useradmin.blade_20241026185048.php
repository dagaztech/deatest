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
</div>
@push('script')
<script>
    $(document).ready(function() {
        var data = [];
        var data2 = [];
        var data3 = [];
        
        @foreach ($lista as $item)
            data.push({ mes: '{{ $item["mes"] }}', fecha: '{{ $item["fecha"] }}' });
        @endforeach
  
        @foreach ($lista2 as $item)
            data2.push({ mes: '{{ $item["mes"] }}', cantidad: '{{ $item["cantidad"] }}', fecha: '{{ $item["fecha"] }}' });
        @endforeach
  
        @foreach ($lista3 as $item)
            data3.push({ edad: '{{ $item["edad"] }}' });
        @endforeach
  
        function agruparPorMes(lista) {
            return Array.from({ length: 12 }, (_, i) => lista.filter(x => x.mes == ("0" + (i + 1)).slice(-2)).length);
        }
  
        function agruparPorDia(lista, mes) {
            return Array.from({ length: 31 }, (_, i) => lista.filter(x => x.mes == mes && x.fecha.split('-')[2] == ("0" + (i + 1)).slice(-2)).length);
        }
  
        // Generación de gráficos
        function generarGraficos(filtro = null) {
            var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
            var seriesUso = agruparPorMes(data);
            var seriesInstalacion = agruparPorMes(data2.map(d => ({ mes: d.mes })));
            var seriesEdad = Object.values(data3.reduce((acc, cur) => (acc[cur.edad] = (acc[cur.edad] || 0) + 1, acc), {}));
  
            if (filtro) {
                if (filtro.tipo === 'mes') {
                    var mesFiltrado = filtro.mes;
                    seriesUso = agruparPorDia(data, mesFiltrado);
                    seriesInstalacion = agruparPorDia(data2, mesFiltrado);
                } else if (filtro.tipo === 'dia') {
                    seriesUso = [data.filter(x => x.fecha === filtro.dia).length];
                    seriesInstalacion = [data2.filter(x => x.fecha === filtro.dia).reduce((acc, cur) => acc + parseInt(cur.cantidad), 0)];
                }
            }
  
            var opcionesUso = {
                series: [{ name: 'Uso del DEA', data: seriesUso }],
                chart: { type: 'bar', height: 350 },
                xaxis: { categories: filtro && filtro.tipo === 'mes' ? Array.from({ length: 31 }, (_, i) => i + 1) : meses },
                yaxis: { title: { text: "Número de Registros" } }
            };
  
            var chartUso = new ApexCharts(document.querySelector("#graficaUso"), opcionesUso);
            chartUso.render();
  
            var opcionesInstalacion = {
                series: [{ name: 'Instalación del DEA', data: seriesInstalacion }],
                chart: { type: 'scatter', height: 350 },
                xaxis: { categories: filtro && filtro.tipo === 'mes' ? Array.from({ length: 31 }, (_, i) => i + 1) : meses },
                yaxis: { title: { text: "Número de Registros" } }
            };
  
            var chartInstalacion = new ApexCharts(document.querySelector("#graficaInstalacion"), opcionesInstalacion);
            chartInstalacion.render();
  
            var opcionesEdad = {
                series: seriesEdad,
                chart: { type: 'pie', width: 550 },
                labels: Object.keys(data3.reduce((acc, cur) => (acc[cur.edad] = (acc[cur.edad] || 0) + 1, acc), {})),
                responsive: [{ breakpoint: 480, options: { chart: { width: 500 }, legend: { position: 'bottom' } } }]
            };
  
            var chartEdad = new ApexCharts(document.querySelector("#graficaEdad"), opcionesEdad);
            chartEdad.render();
        }
  
        // Generar gráficos al cargar la página
        generarGraficos();
  
        // Evento para el botón "Mostrar información"
        $('#mostrarResultados').on('click', function(e) {
            e.preventDefault();
            var tipoFecha = $('#selectorTipoFecha').val();
            var filtro = null;
  
            if (tipoFecha === 'mes') {
                filtro = { tipo: 'mes', mes: $('#inputFechaUnica').val().slice(5, 7) };
            } else if (tipoFecha === 'dia') {
                filtro = { tipo: 'dia', dia: $('#inputFechaUnica').val() };
            } else if (tipoFecha === 'rango') {
                filtro = { tipo: 'rango', rango: $('#inputRangoFechas').val() };
            }
  
            generarGraficos(filtro);
        });
  
        $('#selectorTipoFecha').change(function() {
            var tipo = $(this).val();
            $('#inputFechaUnica, #inputRangoFechas').hide();
  
            if (tipo === 'dia') $('#inputFechaUnica').show();
            else if (tipo === 'rango') $('#inputRangoFechas').show();
        });
  
        $('#inputFechaUnica').flatpickr({ mode: "single", dateFormat: "Y-m-d" });
        $('#inputRangoFechas').flatpickr({ mode: "range", dateFormat: "Y-m-d" });
    });
  </script>
@endpush
  
  
