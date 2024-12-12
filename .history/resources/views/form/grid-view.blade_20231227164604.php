@extends('layouts.main')
@section('title', __('Forms'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Form View') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Form View') }}</li>
        </ul>
        <div class="float-end">
            <div class="d-flex align-items-center">
                <a href="{{ route('grid.form.view') }}" data-bs-toggle="tooltip" title="{{ __('List View') }}"
                    class="btn btn-sm btn-primary" data-bs-placement="bottom">
                    <i class="ti ti-list"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        @foreach ($forms as $form)
            <div class="col-xl-3 d-flex mb-4">
                <div class="text-center text-white card w-100 h-100">
                    <div class="pb-0 border-0 card-header">
                        <div class="d-flex align-items-center">
                            <span class="p-2 px-3 rounded badge bg-primary">{{ $form->title }}</span>
                        </div>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-dots-vertical"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end">
                              
                                   
                                        @if ($form->json)
                                            <a class="dropdown-item" href="{{ route('forms.fill', $form->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                data-bs-original-title="{{ __('Fill Form') }}">
                                                <i class="ti ti-list"></i><span>{{ __('Fill Form') }}</span>
                                            </a>
                                        @endif
                                 
                                 
                                        <a class="dropdown-item" href="javascript:void(0);"
                                            onclick="document.getElementById('duplicate-form-{{ $form->id }}').submit();"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            data-bs-original-title="{{ __('Duplicate Form') }}">
                                            <i class="ti ti-squares-diagonal"></i><span>{{ __('Duplicate Form') }}</span>
                                        </a>
                                   
                                   
                                        <a class="dropdown-item" href="{{ route('forms.design', $form->id) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            data-bs-original-title="{{ __('Design Form') }}">
                                            <i class="ti ti-brush"></i><span>{{ __('Design Form') }}</span>
                                        </a>
                                   
                                  
                                        <a class="dropdown-item" href="{{ route('forms.edit', $form->id) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            data-bs-original-title="{{ __('Edit Form') }}">
                                            <i class="ti ti-edit"></i><span>{{ __('Edit Form') }}</span>
                                        </a>
                                    
                                        {!! Form::open([
                                            'method' => 'DELETE',
                                            'route' => ['forms.destroy', $form->id],
                                            'id' => 'delete-form-' . $form->id,
                                            'class' => 'd-inline',
                                        ]) !!}
                                        <a href="#" class="dropdown-item show_confirm"
                                            id="delete-form-{{ $form->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="bottom" data-bs-original-title="{{ __('Delete') }}"><i
                                                class="mr-0 ti ti-trash"></i><span>{{ __('Delete Form') }}</span>
                                        </a>
                                        {!! Form::close() !!}
                                   
                                        {!! Form::open(['method' => 'POST', 'route' => ['forms.duplicate'], 'id' => 'duplicate-form-' . $form->id]) !!}
                                        {!! Form::hidden('form_id', $form->id, []) !!}
                                        {!! Form::close() !!}
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <img src="{{ isset($form->logo) ? Storage::url($form->logo) : Storage::url('app-logo/78x78.png') }}"
                            alt="user-image" width="100px" class="rounded-circle">
                        <h4 class="mt-2 text-dark">{{ $form->title }}</h4>
                        <small class="text-dark">{{ $form->email }}</small>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-3 d-flex">
            <a href="{{ route('forms.create') }}" class="btn-addnew-project w-100">
                <div class="bg-primary add_user proj-add-icon">
                    <i class="ti ti-plus"></i>
                </div>
                <h6 class="mt-4 mb-2">{{ __('New Form') }}</h6>
                <p class="text-center text-muted">{{ __('Click here to add new form') }}</p>
            </a>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).attr('data-url')).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Great!', '{{ __('Copied.') }}', 'success',
                '{{ asset('assets/images/notification/ok-48.png') }}', 4000);
        }
        $(function() {
            $(document).on('click', '.add_user', function() {
                window.location.href = '{{ route('forms.create') }}';
            });
            $(document).on('click', '#share-qr-code', function() {
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
