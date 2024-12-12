@extends('layouts.main')
@section('title', __('Formularios'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Formularios') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Panel de Control'), []) !!}</li>
            <li class="breadcrumb-item active"> {{ __('Formularios') }} </li>
        </ul>
        <div class="float-end">
            <div class="d-flex align-items-center">
                <a href="{{ route('grid.form.view', 'view') }}" data-bs-toggle="tooltip" title="{{ __('Vista tipo grid') }}"
                    class="btn btn-sm btn-primary" data-bs-placement="bottom">
                    <i class="ti ti-layout-grid"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row table-holder normal-width">
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
    @include('layouts.includes.datatable-css')
@endpush
@push('script')
    @include('layouts.includes.datatable-js')
    {{ $dataTable->scripts() }}
    <script>
        $.fn.dataTable.ext.errMode = 'throw';
        /*$.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) {
        // message doesn't show from here
            alert("a")
    };*/
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).attr('data-url')).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('¡Bien!', '{{ __('Enlace copiado exitosamente.') }}', 'success',
                '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
        }
        $(function() {
            $('body').on('click', '#share-qr-code', function() {
                var action = $(this).data('share');
                var modal = $('#common_modal2');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('QR Code') }}');
                    modal.find('.modal-body').html(response.html);
                    feather.replace();
                    modal.modal('show');
                })
            });
        });
    </script>
@endpush
