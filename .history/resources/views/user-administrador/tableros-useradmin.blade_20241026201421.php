<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableros de Usuario</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>
<body>
    <div id="grafico1"></div>
    <div id="grafico2"></div>
    <div id="grafico3"></div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Formulario de filtro -->
    <form id="filtro-form">
        <input type="text" id="single" name="single" placeholder="Fecha específica">
        <input type="text" id="rango" name="rango" placeholder="Rango de fechas">
        <button type="button" id="filtro-btn">Filtrar</button>
    </form>
    
    <script>
        $('#filtro-btn').on('click', function() {
            var single = $('#single').val();
            var rango = $('#rango').val();
    
            $.ajax({
                url: "{{ route('ruta.filtrar') }}",  // Cambia 'ruta.filtrar' a la ruta correcta
                method: 'GET',
                data: {
                    single: single,
                    rango: rango
                },
                success: function(response) {
                    // Actualizar gráficos con los nuevos datos
                    chart1.updateSeries([{
                        data: response.lista.map(item => parseInt(item.mes))
                    }]);
    
                    chart2.updateSeries([{
                        data: response.lista2.map(item => parseInt(item.cantidad))
                    }]);
    
                    chart3.updateSeries(response.lista3.map(item => parseInt(item.edad)));
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
    
    <script>
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
    </script>
</body>
</html>
