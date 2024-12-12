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
                        <form id="filterForm">
                            @csrf
                            <div class="row">
                                <div class="form-group d-flex justify-content-start col-sm-4">
                                    <input class="form-control mr-1 created_at flatpickr-input" placeholder="Selecciona rango de fechas" id="pc-daterangepicker-1" name="rango" type="text" readonly="readonly">
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" id="filterBtn">Filtrar</button>
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
    $(document).ready(function () {
        // Inicialización del date picker
        document.querySelector("#pc-daterangepicker-1").flatpickr({
            mode: "range",
            maxDate: "today",
            dateFormat: "Y-m-d",
        });

        // Envío de los filtros al servidor
        $('#filterBtn').on('click', function () {
            let rango = $('#pc-daterangepicker-1').val();
            $.ajax({
                url: "{{ url('user-administrador/tableros-useradmin') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    rango: rango,
                },
                success: function (response) {
                    // Renderizar gráficos con los datos recibidos
                    renderCharts(response.lista, response.lista2, response.lista3);
                }
            });
        });

        // Función para renderizar gráficos
        function renderCharts(lista, lista2, lista3) {
            // Uso del DEA
            var chart1 = new ApexCharts(document.querySelector("#graficaUso"), {
                series: [{ data: lista }],
                chart: { type: 'bar', height: 350 },
                xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"] }
            });
            chart1.render();

            // Instalación del DEA
            var chart2 = new ApexCharts(document.querySelector("#graficaInstalacion"), {
                series: [{ data: lista2 }],
                chart: { type: 'bar', height: 350 },
                xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"] }
            });
            chart2.render();

            // Uso de Edad Promedio
            var chart3 = new ApexCharts(document.querySelector("#graficaEdad"), {
                series: [{ data: lista3 }],
                chart: { type: 'pie', width: 550 },
                labels: Object.keys(lista3)
            });
            chart3.render();
        }
    });
</script>
@endpush
