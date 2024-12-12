@extends('layouts.main')
@section('title', __('Notificaciones por Email'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Notificaciones por Email') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Panel de Control'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Notificaciones por Email') }} </li>
        </ul>
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
            <hr>
            <a href="{{ route('mailtemplate.create') }}" alt="Crear Notificación por Email" class=" btn btn-primary">Crear Notificación por Email</a>
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
@endpush

