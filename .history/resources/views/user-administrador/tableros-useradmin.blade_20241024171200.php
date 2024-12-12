@extends('layouts.main')
@section('title', __('Tableros de Uso e Instalación de DEA'))

@section('content')
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
                                        <select id="selectorTipoFecha" class="form-control">
                                            <option value="dia">Por Día</option>
                                            <option value="rango">Por Rango</option>
                                        </select>

                                        <!-- Input para seleccionar fecha única -->
                                        <input id="inputFechaUnica" type="text" class="form-control mt-2" placeholder="Seleccionar día" style="display:none;">

                                        <!-- Input para seleccionar rango de fechas -->
                                        <input id="inputRangoFechas" type="text" class="form-control mt-2" placeholder="Seleccionar rango" style="display:none;">

                                        <!-- Input para filtrar por día -->
                                        <div id="dia-filter" style="display:none;">
                                            <input id="pc-daterangepicker-dia" placeholder="Selecciona un día" class="form-control mt-2" />
                                        </div>

                                        <!-- Input para filtrar por rango de fechas -->
                                        <div id="rango-filter" style="display:none;">
                                            <input id="pc-daterangepicker-rango" placeholder="Selecciona un rango de fechas" class="form-control mt-2" />
                                        </div>

                                        <!-- Botón para mostrar los gráficos -->
                                        <button type="button" id="mostrarResultados" class="btn btn-primary mt-3">Mostrar información</button>
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
                                <h3>EDAD PROMEDIO</h3>
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
                <div class="logos_footer_gov">
                    <a href="https://www.colombia.co" target="_blank">
                        <img class="marcaco_l" src="../../images/logo.png" alt="colombia.co">
                    </a>
                </div>
                <div class="alcaldia_mod_footer">
                    <a href="https://www.medellin.gov.co/es">
                        <img class="log_nww_footer" src="../../images/logo_nav_footer.png" alt="Alcaldía de Medellín">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('vendor/apex-chart/apexcharts.min.js') }}"></script>

<script>
$(document).ready(function() {
    var data = [];
    var data2 = [];
    var data3 = [];

    @foreach ($lista as $item)
        data.push('{{ $item["mes"] }}');
    @endforeach

    @foreach ($lista2 as $item)
        data2.push({ mes: '{{ $item["mes"] }}', cantidad: '{{ $item["cantidad"] }}' });
    @endforeach

    @foreach ($lista3 as $item)
        data3.push('{{ $item["edad"] }}');
    @endforeach

    const groups = data3.reduce((agg, curr) => {
        agg[curr] = (agg[curr] || 0) + 1;
        return agg;
    }, {});

    function generarGraficos() {
        var options = {
            series: [{ data: data.map(m => data.filter(x => x === m).length) }],
            chart: { type: 'bar', height: 350 },
            plotOptions: { bar: { borderRadius: 4, horizontal: true } },
            xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] }
        };
        var chart = new ApexCharts(document.querySelector("#graficaUso"), options);
        chart.render();

        var options2 = {
            series: [{ data: data2.map(d => d.cantidad) }],
            chart: { type: 'bar', height: 350 },
            plotOptions: { bar: { borderRadius: 4, horizontal: true } },
            xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] }
        };
        var chart2 = new ApexCharts(document.querySelector("#graficaInstalacion"), options2);
        chart2.render();

        var options3 = {
            series: Object.values(groups),
            chart: { width: 550, type: 'pie' },
            labels: Object.keys(groups),
            responsive: [{ breakpoint: 480, options: { chart: { width: 500 }, legend: { position: 'bottom' } } }]
        };
        var chart3 = new ApexCharts(document.querySelector("#graficaEdad"), options3);
        chart3.render();
    }

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

    $('#inputFechaUnica').flatpickr({ mode: "single", dateFormat: "Y-m-d" });
    $('#inputRangoFechas').flatpickr({ mode: "range", dateFormat: "Y-m-d" });
});
</script>

@endpush
@endsection
