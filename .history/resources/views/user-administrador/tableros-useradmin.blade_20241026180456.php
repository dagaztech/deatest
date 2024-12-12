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
                        <div class="row">
                          <div class="form-group col-sm-4">
                            <input class="form-control" placeholder="Selecciona rango de fechas" id="rangoFechas" name="rango" type="text" >
                          </div>
                          <div class="form-group col-sm-4">
                            <input class="form-control" placeholder="Selecciona día específico" id="diaEspecifico" name="dia" type="text" >
                          </div>
                          <div class="col-sm-4">
                            <button type="button" onclick="filtrarDatos()">Filtrar</button>
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

@push('script')
<script src="{{ asset('vendor/apex-chart/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inicializar los calendarios
        flatpickr("#rangoFechas", { mode: "range", maxDate: "today" });
        flatpickr("#diaEspecifico", { dateFormat: "Y-m-d", maxDate: "today" });

        // Función para renderizar gráficos
        function renderCharts(data) {
            // Opciones de gráficos para Uso del DEA, Instalación del DEA y Edad Promedio
            // ... (Usar las opciones de gráficos como en el código previo, adaptados a los datos recibidos)

            // Asignar opciones de gráfico Uso del DEA
            const usoOptions = {
                series: [{
                    data: data.listaPorMesDia
                }],
                chart: { type: 'heatmap', height: 350 },
                xaxis: { categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
            'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"
          ], },
                yaxis: { categories: [...Array(31).keys()].map(n => n + 1) }
            };
            new ApexCharts(document.querySelector("#graficaUso"), usoOptions).render();

            // Asignar opciones de gráfico Instalación del DEA y Edad Promedio
            // Similar lógica para los otros gráficos...
        }

        // Función para filtrar datos
        async function filtrarDatos() {
            const rango = document.querySelector("#rangoFechas").value;
            const dia = document.querySelector("#diaEspecifico").value;
            const formData = new FormData();
            formData.append("rango", rango);
            formData.append("dia", dia);

            try {
                const response = await fetch("{{ url('user-administrador/tableros-useradmin') }}", {
                    method: "POST",
                    headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: formData
                });
                const data = await response.json();
                renderCharts(data); // Actualizar gráficos con datos filtrados
            } catch (error) {
                console.error("Error al filtrar datos:", error);
            }
        }

        // Cargar gráficos al inicio con datos completos
        fetch("{{ url('user-administrador/tableros-useradmin') }}", {
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        })
            .then(response => response.json())
            .then(data => renderCharts(data))
            .catch(error => console.error("Error al cargar gráficos:", error));
    });
</script>

<script>
    // Inicialización de Flatpickr para rango de fechas
    flatpickr("#rangoFechas", {
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

<script>
    // Inicialización de Flatpickr para seleccion por dias
    flatpickr("#diaEspecifico", {
        mode: "single",
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
