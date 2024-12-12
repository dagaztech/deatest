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
                        <form id="filter-form">
                            @csrf 
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <input class="form-control mr-1 created_at" placeholder="Selecciona rango de fechas" id="pc-daterangepicker-1" name="rango" type="text" readonly="readonly">
                                </div>
                                <div class="col-sm-4">
                                    <button type="button" id="filter-btn">Filtrar</button>
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
        // Inicializar flatpickr
        document.querySelector("#pc-daterangepicker-1").flatpickr({
            mode: "range",
            maxDate: "today",
            dateFormat: "Y-m-d",
            locale: {
                firstDayOfWeek: 1,
                weekdays: { shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'], longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] },
                months: { shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'], longhand: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] }
            }
        });

        // Función para crear y actualizar gráficos
        function renderCharts(lista, lista2, lista3) {
            $("#graficaUso, #graficaInstalacion, #graficaEdad").empty(); // Limpiar los gráficos

            // Gráfica de Uso del DEA
            var chartUso = new ApexCharts(document.querySelector("#graficaUso"), {
                series: [{ data: lista }],
                chart: { type: 'bar', height: 350 },
                plotOptions: { bar: { borderRadius: 4, horizontal: true } },
                xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"] },
            });
            chartUso.render();

            // Gráfica de Instalación del DEA
            var chartInstalacion = new ApexCharts(document.querySelector("#graficaInstalacion"), {
                series: [{ data: lista2 }],
                chart: { type: 'bar', height: 350 },
                plotOptions: { bar: { borderRadius: 4, horizontal: true } },
                xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"] },
            });
            chartInstalacion.render();

            // Gráfica de Uso de Edad Promedio
            var chartEdad = new ApexCharts(document.querySelector("#graficaEdad"), {
                series: Object.values(lista3),
                chart: { type: 'pie', width: 550 },
                labels: Object.keys(lista3),
                responsive: [{ breakpoint: 480, options: { chart: { width: 500 }, legend: { position: 'bottom' } } }],
            });
            chartEdad.render();
        }

        // Función para manejar la solicitud de filtrado
        $('#filter-btn').click(function() {
            let rango = $('#pc-daterangepicker-1').val();
            $.ajax({
                url: "{{ url('user-administrador/tableros-useradmin') }}",
                method: "POST",
                data: { rango: rango, _token: "{{ csrf_token() }}" },
                success: function(response) {
                    renderCharts(response.lista, response.lista2, response.lista3); // Renderizar los datos en las gráficas
                },
                error: function() {
                    alert('Hubo un error al cargar los datos.');
                }
            });
        });
    });
</script>



@endpush
