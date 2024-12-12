@extends('layouts.main')

@section('title', __('Gráficas BI'))

@section('content')

<div class="section-body">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
            <div class="card" id="purple-btn">
                <div class="card-header">
                    <h5 class="text-center w-100" id="new-title">Graficas BI</h5>
                </div>
                <div class="card-body form-card-body">
                    <div class="row">
           
    <div class="graphicblock">
        @foreach($charts as $chart)
            <div style="width: 31%; margin-bottom: 20px;">
                <h6>Form ID: {{ $chart['form_id'] }}</h6>
                <canvas id="chart-{{ $chart['form_id'] }}"></canvas>
                <script>
                    const ctx{{ $chart['form_id'] }} = document.getElementById('chart-{{ $chart['form_id'] }}').getContext('2d');
                    new Chart(ctx{{ $chart['form_id'] }}, {
                        type: '{{ $chart['type'] }}', // Tipo de gráfico
                        data: {
                            labels: {!! json_encode($chart['labels']) !!},
                            datasets: [{
                                label: 'Valores de Form ID {{ $chart['form_id'] }}',
                                data: {!! json_encode($chart['data']) !!},
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                        }
                    });
                </script>
            </div>
        @endforeach
    </div>  </div>
</div>
        </div>
    </div>
</div>
<div class="forms-footer">
    <div class="footer-bottom footer-mobile">
        <div class="footer_gov_">
           <div class="centradototal_ fooflex">
              <div class="logos_footer_gov"><a href="https://www.colombia.co" target="_blank"><img class="marcaco_l" src="../../images/logo.png" alt="colombia.co"></a></div>
              <div class="alcaldia_mod_footer"><a href="https://www.medellin.gov.co/es"><img  class="log_nww_footer" src="../../images/logo_nav_footer.png" alt="Alcaldía de Medellín"></a></div>
           </div>
        </div>
     </div>
</div>
@endsection

@push('script')
<style>
    .graphicblock{display: flex; flex-wrap: wrap; gap: 0.5%;}
    .graphicblock h6{
    text-align: center;
    background: #eee;
    padding: 10px;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
