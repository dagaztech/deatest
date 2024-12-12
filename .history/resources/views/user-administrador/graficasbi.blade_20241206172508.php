@extends('layouts.main')
@section('title', __('Gráficas BI'))

<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card" >
    <h1>Gráficas BI</h1>
    <div style="width: 600px;">
        <canvas id="graficoLinea"></canvas>
    </div>
    <div style="width: 600px;">
        <canvas id="graficoTorta"></canvas>
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

@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos para gráfico de línea
        const dataLinea = {
            labels: @json(array_keys($procesado['totales'])),
            datasets: [{
                label: 'Cantidad por Categoría',
                data: @json(array_values($procesado['totales'])),
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: false
            }]
        };

        // Configuración del gráfico de línea
        const configLinea = {
            type: 'line',
            data: dataLinea,
        };

        // Renderizar gráfico de línea
        new Chart(
            document.getElementById('graficoLinea'),
            configLinea
        );

        // Datos para gráfico de torta
        const dataTorta = {
            labels: @json(array_keys($procesado['totales'])),
            datasets: [{
                data: @json(array_values($procesado['totales'])),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
            }]
        };

        // Configuración del gráfico de torta
        const configTorta = {
            type: 'pie',
            data: dataTorta,
        };

        // Renderizar gráfico de torta
        new Chart(
            document.getElementById('graficoTorta'),
            configTorta
        );
    </script>

@endpush