@extends('layouts.main')
@section('title', __('Crear Notificación por Email'))
@section('breadcrumb')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h4 class="m-b-10">{{ __('Crear Notificación por Email') }}</h4>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">{!! Html::link(route('home'), __('Panel de Control'), []) !!}</li>
                        <li class="breadcrumb-item">{!! Html::link(route('mailtemplate.index'), __('Notificaciones por Email'), []) !!}</li>
                        <li class="breadcrumb-item active">{{ __('Crear Notificación por Email') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="layout-px-spacing row normal-width" >
        <div id="basic" class="mx-auto col-lg-12 layout-spacing">
            <div class="statbox card box box-shadow">
                <div class="card-header">
                    <h5>{{ __('Crear Notificación por Email') }}</h5>
                </div>
                {!! Form::open(['route' => 'mailtemplate.store', 'method' => 'Post','data-validate' ]) !!}
                <div class="card-body">
                    <div class="row">
                        <div class="mx-auto col-lg-12 col-12">
                            <div class="form-group">
                                {{ Form::label('mailable', __('Mailable'), ['class' => 'form-label']) }}
                                {!! Form::text('mailable', null, ['placeholder' => 'Nombre de plantilla de notificación', 'class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('subject', __('Subject'), ['class' => 'form-label']) }}
                                {!! Form::text('subject', null, [
                                    'placeholder' => 'Asunto del mensaje en la notificación',
                                    'class' => 'form-control',
                                    'required',
                                ]) !!}
                            </div>
                            <div class="form-group">
                                {{ Form::label('html_template', __('Html Template'), ['class' => 'form-label']) }}
                                {!! Form::textarea('html_template', null, [
                                    'placeholder' => 'Ingrese el texto o plantilla en HTML de la notificación',
                                    'class' => 'form-control',
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-end">
                        {!! Html::link(route('mailtemplate.index'), __('Cancel'), ['class'=>'btn btn-secondary']) !!}
                        {{ Form::button(__('Save'),['type' => 'submit','class' => 'btn btn-primary']) }}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        CKEDITOR.replace('html_template', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
