@extends('layouts.main')

@section('title', __('Gráficas BI'))

@section('content')

<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
           
            <h1>Gráficas para cada Form ID</h1>
    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        @foreach($charts as $chart)
            <div style="width: 30%; margin-bottom: 20px;">
                <h3>Form ID: {{ $chart['form_id'] }}</h3>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush
