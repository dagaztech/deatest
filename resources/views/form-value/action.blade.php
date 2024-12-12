   @if (\Auth::guard('api')->user()->rol != "Usuario operador 1")
   <a href="{{ route('form-values.show', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
    data-bs-original-title="{{ __('Show') }}" title="{{ __('View Survey') }}"
    class="btn btn-info btn-sm" data-toggle="tooltip"><i class="ti ti-eye"></i></a>
    <a href="{{ route('form-values.edit', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
         data-bs-original-title="{{ __('Edit') }}" title="{{ __('Edit Survey') }}"
        class="btn btn-primary btn-sm" data-toggle="tooltip"><i class="ti ti-edit"></i> </a>
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['form-values.destroy', $formValue->id],
        'id' => 'delete-form-' . $formValue->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Delete') }}" id="delete-form-{{ $formValue->id }}"><i class="ti ti-trash"></i></a>
    {!! Form::close() !!}
    @else (\Auth::guard('api')->user()->rol == "Usuario operador 1")
    <a href="{{ route('form-values.show', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Show') }}" title="{{ __('View Survey') }}"
        class="btn btn-info btn-sm" data-toggle="tooltip"><i class="ti ti-eye"></i></a>
    <a href="{{ route('form-values.edit', $formValue->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
         data-bs-original-title="{{ __('Edit') }}" title="{{ __('Edit Survey') }}"
        class="btn btn-primary btn-sm" data-toggle="tooltip"><i class="ti ti-edit"></i> </a>
    @endif

    