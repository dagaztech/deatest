@php
    $user = \Auth::guard('api')->user();
    $color = $user->theme_color;
    if ($color == 'theme-1') {
        $chatcolor = '#0CAF60';
    } elseif ($color == 'theme-2') {
        $chatcolor = '#584ED2';
    } elseif ($color == 'theme-3') {
        $chatcolor = '#6FD943';
    } elseif ($color == 'theme-4') {
        $chatcolor = '#145388';
    } elseif ($color == 'theme-5') {
        $chatcolor = '#B9406B';
    } elseif ($color == 'theme-6') {
        $chatcolor = '#008ECC';
    } elseif ($color == 'theme-7') {
        $chatcolor = '#922C88';
    } elseif ($color == 'theme-8') {
        $chatcolor = '#C0A145';
    } elseif ($color == 'theme-9') {
        $chatcolor = '#48494B';
    } elseif ($color == 'theme-10') {
        $chatcolor = '#0C7785';
    }

@endphp
@extends('layouts.main')
@section('title', __('Formulario registrado'))
@section('breadcrumb')

@endsection
@section('content')
<style>
        .submitformtable #forms-table > thead > tr > th:nth-child(3), .submitformtable #forms-table > thead > tr > th:nth-child(4), .submitformtable #forms-table > thead > tr > th:nth-child(5), .submitformtable #forms-table > thead > tr > th:nth-child(6), .submitformtable #forms-table > tbody > tr > td:nth-child(3), .submitformtable #forms-table > tbody > tr > td:nth-child(4), .submitformtable #forms-table > tbody > tr > td:nth-child(5), .submitformtable #forms-table > tbody > tr > td:nth-child(6){
            display: table-cell !important;
        }
        table, th, td, table.dataTable {
        border-collapse: collapse  !important;
      }
      table.dataTable td, table.dataTable th {
    -webkit-box-sizing: content-box;
    box-sizing: content-box;
    max-width: 300px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

    </style>
    <div class="row">
        <div class="main-content">
            <section class="section">
                <p>&nbsp;</p>
                        <p>&nbsp;</p>
                <h2 class="text-center">{{ $formsDetails->title }}</h2>
                <div class="section-body filter">
                    <div class="row">
                        <div class="mt-4 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                   
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 responsive-search">
                                                <div class="form-group d-flex justify-content-start">
                                                    {{ Form::text('user', null, ['class' => 'form-control mr-1 ', 'placeholder' => __('Buscar'), 'data-kt-ecommerce-category-filter' => 'search']) }}
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 responsive-search">
                                                <div class="form-group row d-flex justify-content-start">
                                                    {{ Form::text('duration', null, ['class' => 'form-control mr-1 created_at', 'placeholder' => __('Selecciona rango de fechas'), 'id' => 'pc-daterangepicker-1', 'onchange' => 'updateEndDate()']) }}
                                                    {!! Form::hidden('form_id', $formsDetails->id, ['id' => 'form_id']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 btn-responsive-search">
                                                {{ Form::button(__('Filtrar'), ['class' => 'btn btn-primary btn-lg  add_filter button-left']) }}
                                                {{ Form::button(__('Limpiar filtro'), ['class' => 'btn btn-secondary btn-lg clear_filter']) }}
                                                {!! Form::open([
                                                    'route' => ['download.form.values.excel'],
                                                    'method' => 'post',
                                                    'id' => 'mass_export',
                                                    'class' => 'd-inline-block',
                                                ]) !!}
                                                {{ Form::hidden('form_id', $formsDetails->id) }}
                                                {{ Form::hidden('select_date') }}
                                              
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    
                                    <div class="mt-5 row">
                                        <div class="col-md-12">
                                            <div class="py-4 table-responsive submitformtable">
                                                {{ $dataTable->table(['width' => '100%']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12" id="chart_div" style="display:none !important;">
                                    <style>
                                        .pie-chart {
                                            width: 100%;
                                            height: 400px;
                                            margin: 0 auto;
                                            float: right;
                                        }

                                        .text-center {
                                            text-align: center;
                                        }

                                        @media (max-width: 991px) {
                                            .pie-chart {
                                                width: 100%;
                                            }
                                        }
                                    </style>
                                    <div class="row">
                                        @php($key = 1)
                                        @foreach ($chartData as $chart)
                                            <div class="col-md-6 col-xl-4" data-id="1">
                                                <div class="card">
                                                    @if (isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == 'true')
                                                        <div class="card-header">
                                                            <h5 class="mb-0">
                                                                {{ $chart['label'] }}
                                                            </h5>
                                                        </div>
                                                    @endif
                                                    <div class="col-sm-12">
                                                        @if (isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'bar')
                                                            <div id="chartDiv-{{ $key }}"
                                                                class="pie-chart d-flex align-items-center"></div>
                                                        @endif
                                                        @if (isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'pie')
                                                            <div id="chartDive-{{ $key }}"
                                                                class="pie-chart d-flex align-items-center">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <script type="text/javascript">
                                                var colors = '<?php echo $chatcolor; ?>';

                                                function drawChart{{ $key }}() {
                                                    @if (isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'bar')
                                                        var colWidth = (@json(array_keys($chart['options'])).length * 7) + '%';
                                                        var options = {
                                                            chart: {
                                                                type: 'bar',
                                                                toolbar: {
                                                                    show: false
                                                                }
                                                            },
                                                            plotOptions: {
                                                                bar: {
                                                                    columnWidth: colWidth,
                                                                    borderRadius: 5,
                                                                    dataLabels: {
                                                                        position: 'top',
                                                                    },
                                                                }
                                                            },
                                                            colors: colors,
                                                            dataLabels: {
                                                                enabled: false,
                                                            },
                                                            stroke: {
                                                                show: true,
                                                                width: 1,
                                                                colors: ['#fff']
                                                            },
                                                            grid: {
                                                                strokeDashArray: 4,
                                                            },
                                                            series: [{
                                                                name: @json($chart['label']),
                                                                data: @json(array_values($chart['options'])),
                                                            }],
                                                            xaxis: {
                                                                categories: @json(array_keys($chart['options'])),
                                                            },
                                                        };
                                                        var chart = new ApexCharts(document.querySelector("#chartDiv-{{ $key }}"), options);
                                                        chart.render();
                                                    @endif
                                                    @if (isset($chart['is_enable_chart']) && $chart['is_enable_chart'] == true && $chart['chart_type'] == 'pie')
                                                        var options = {
                                                            series: @json(array_values($chart['options'])),
                                                            chart: {
                                                                width: '100%',
                                                                type: 'donut',
                                                            },
                                                            plotOptions: {
                                                                pie: {
                                                                    startAngle: -90,
                                                                    endAngle: 270
                                                                }
                                                            },
                                                            labels: @json(array_keys($chart['options'])),
                                                            dataLabels: {
                                                                enabled: false
                                                            },
                                                            fill: {
                                                                type: 'gradient',
                                                            },
                                                            legend: {
                                                                formatter: function(val, opts) {
                                                                    return val + " - " + opts.w.globals.series[opts
                                                                        .seriesIndex]
                                                                }
                                                            },
                                                            responsive: [{
                                                                breakpoint: 480,
                                                                options: {
                                                                    chart: {
                                                                        width: 200
                                                                    },
                                                                    legend: {
                                                                        position: 'bottom'
                                                                    }
                                                                }
                                                            }]
                                                        };
                                                        var chart = new ApexCharts(document.querySelector("#chartDive-{{ $key }}"), options);
                                                        chart.render();
                                                    @endif
                                                }
                                            </script>
                                            @php($key++)
                                        @endforeach
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" />
    @include('layouts.includes.datatable-css')
@endpush
@push('script')
    <script src="{{ asset('assets/js/loader.js') }}"></script>
    
    <script src="{{ asset('assets/js/plugins/flatpickr.min.js') }}"></script>
    <script src="{{ asset('vendor/apex-chart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
    <script>
        
        window.onload = function() {

            @php($key = 1)
            @foreach ($chartData as $chart)
                drawChart{{ $key }}();
                @php($key++)
            @endforeach
        };
        document.querySelector("#pc-daterangepicker-1").flatpickr({
            mode: "range",
            mode: "range",
                maxDate: "today",
                locale: {
        firstDayOfWeek: 1,
        weekdays: {
          shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
          longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
        }, 
        months: {
          shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
          longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        },
      },
    dateFormat: "Y-m-d",
    disable: [
        function(date) {
            return !(date.getDate());
        }
    ]
        });
    </script>
    <script>
        function updateEndDate() {
            var duration = document.getElementById('pc-daterangepicker-1').value;
            var startDate = '';
            var startDateArray = duration.split(' - ');
            if (startDateArray.length > 0) {
                startDate = startDateArray[0];
            }
            document.querySelector('input[name="select_date"]').value = startDate;
        }
    </script>
    <!--PARA TRADUCIR BOTONES DE SUBMIT Y SIMILARES-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Selecciona todos los botones en la página
        const botones = document.querySelectorAll("button");
    
        // Diccionario de traducciones
        const traducciones = {
            "Next": "Siguiente",
            "Previous": "Anterior",
            "Submit": "Enviar",
            "Clear": "Limpiar",
            "Claro": "Limpiar"
        };
    
        // Recorre cada botón y verifica si su texto está en inglés
        botones.forEach(function(boton) {
            const textoBoton = boton.textContent.trim();
            
            // Si el texto del botón está en el diccionario, lo traduce
            if (traducciones[textoBoton]) {
                boton.textContent = traducciones[textoBoton];
            }
        });
    });
    </script>

@endpush
