@extends('layouts.main')
@section('title', __('Email Templates'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Email Templates') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Email Templates') }} </li>
        </ul>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card normal-width">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    {{ $dataTable->table(['width' => '100%']) }}
                </div>
            </div>
            <hr>
            <a href="{{ route('mailtemplate.create') }}" alt="Crear nuevo correo" class=" btn btn-primary">Crear nuevo correo</a>
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
