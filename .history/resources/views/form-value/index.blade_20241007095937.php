@extends('layouts.main')
@section('title', __('Formularios Diligenciados'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Formularios Diligenciados') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Panel de Control'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Formularios Diligenciados') }} </li>
        </ul>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    {{ $dataTable->table(['width' => '100%']) }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" />
    @include('layouts.includes.datatable-css')
@endpush
@push('script')
    <script type="text/javascript" src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    @include('layouts.includes.datatable-js')
     {{ $dataTable->scripts() }}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var genericExamples = document.querySelectorAll('[data-trigger]');
            for (i = 0; i < genericExamples.length; ++i) {
                var element = genericExamples[i];
                new Choices(element, {
                    placeholderValue: 'Este es un marcador de posición establecido en la configuración.',
                    searchPlaceholderValue: 'Este es un marcador de posición de búsqueda',
                });
            }
        });
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
