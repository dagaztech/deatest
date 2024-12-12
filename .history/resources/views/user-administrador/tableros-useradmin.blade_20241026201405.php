<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableros de Usuario</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Contenedores para las gráficas -->
    <div id="grafico1" style="height: 400px;"></div>
    <div id="grafico2" style="height: 400px;"></div>
    <div id="grafico3" style="height: 400px;"></div>

    <script>
        // Datos iniciales de PHP
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
                url: "{{ route('ruta.filtrar') }}",  // Cambia 'ruta.filtrar' por la ruta correcta
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
    </script>
</body>
</html>
