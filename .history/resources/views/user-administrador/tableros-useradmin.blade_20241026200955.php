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
