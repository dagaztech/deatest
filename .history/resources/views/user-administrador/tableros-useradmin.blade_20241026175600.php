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
                                <!-- Rango de Fechas -->
                                <div class="form-group col-sm-4">
                                    <input class="form-control created_at flatpickr-input" placeholder="Selecciona rango de fechas" id="pc-daterangepicker-1" onchange="updateEndDate()" name="rango" type="text" readonly="readonly">
                                </div>
                                <!-- Día Específico -->
                                <div class="form-group col-sm-4">
                                    <input class="form-control" placeholder="Selecciona día específico" id="day-input" name="dia" type="number" min="1" max="31">
                                </div>
                                <div class="col-sm-4">
                                    <input type="submit" value="Filtrar">
                                </div>
                            </div>
                        </form>
                        <div id="graficaUso"></div>
                        <div id="graficaInstalacion"></div>
                        <div id="graficaEdad"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push(script)
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Función para renderizar gráficos
    function renderCharts(lista, lista2, lista3) {
        // Configuración y renderización de gráfico de uso
        const usageOptions = {
            series: [{
                data: Array.from({length: 31}, (_, day) => lista.filter(x => x.dia == (day + 1).toString().padStart(2, '0')).length)
            }],
            chart: { type: 'heatmap', height: 350 },
            xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"] },
            yaxis: { categories: Array.from({length: 31}, (_, i) => i + 1) }
        };
        const usageChart = new ApexCharts(document.querySelector("#graficaUso"), usageOptions);
        usageChart.render();

        // Configuración y renderización de gráfico de instalación
        const installationOptions = {
            series: [{ data: Array.from({length: 31}, (_, day) => lista2.filter(x => x.dia == (day + 1).toString().padStart(2, '0')).reduce((sum, x) => sum + parseInt(x.cantidad), 0)) }],
            chart: { type: 'heatmap', height: 350 },
            xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"] },
            yaxis: { categories: Array.from({length: 31}, (_, i) => i + 1) }
        };
        const installationChart = new ApexCharts(document.querySelector("#graficaInstalacion"), installationOptions);
        installationChart.render();

        // Configuración y renderización de gráfico de edades
        const ageCounts = lista3.reduce((acc, x) => {
            acc[x.edad] = (acc[x.edad] || 0) + 1;
            return acc;
        }, {});
        const ageOptions = {
            series: Object.values(ageCounts),
            chart: { width: 550, type: 'pie' },
            labels: Object.keys(ageCounts),
            responsive: [{ breakpoint: 480, options: { chart: { width: 500 }, legend: { position: 'bottom' } } }]
        };
        const ageChart = new ApexCharts(document.querySelector("#graficaEdad"), ageOptions);
        ageChart.render();
    }

    // Llamar a renderCharts con datos iniciales de Laravel o luego de filtrar
    renderCharts(@json($lista), @json($lista2), @json($lista3));
});
</script>

<script>
    // Inicialización de Flatpickr para rango de fechas
    flatpickr("#pc-daterangepicker-1", {
        mode: "range",
        maxDate: "today",
        locale: {
            firstDayOfWeek: 1,
            weekdays: { shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'], longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'] },
            months: { shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'], longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] },
        },
        dateFormat: "Y-m-d"
    });
</script>



@endpush
