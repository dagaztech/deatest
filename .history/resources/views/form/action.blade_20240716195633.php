
        @if ($form->is_active)
            @php
                $hashids = new Hashids('', 20);
                $id = $hashids->encodeHex($form->id);
            @endphp


            <a class="btn btn-success btn-sm copy_form" onclick="copyToClipboard('#copy-form-{{ $form->id }}')"
                href="javascript:void(0)" id="copy-form-{{ $form->id }}" data-bs-toggle="tooltip"
                data-bs-placement="bottom" data-bs-original-title="{{ __('Copy Form URL') }}"
                data-url="{{ route('forms.survey', $id) }}"><i class="ti ti-copy"></i></a>
                @endif
         
    <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Design Form') }}" href="{{ route('forms.design', $form->id) }}"><i
            class="ti ti-brush"></i></a>
    <a class="btn btn-primary btn-sm" href="{{ route('forms.edit', $form->id) }}" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="{{ __('Edit Form') }}" id="edit-form"><i
            class="ti ti-edit"></i></a>

    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['forms.destroy', $form->id],
        'id' => 'delete-form-' . $form->id,
        'class' => 'd-inline',
    ]) !!}
    <a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ __('Delete') }}" id="delete-form-{{ $form->id }}"><i
            class="mr-0 ti ti-trash"></i></a>
    {!! Form::close() !!}


    {!! Form::open(['method' => 'POST', 'route' => ['forms.duplicate'], 'id' => 'duplicate-form-' . $form->id]) !!}
    {!! Form::hidden('form_id', $form->id, []) !!}
    {!! Form::close() !!}
