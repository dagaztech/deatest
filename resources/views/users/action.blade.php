<span>
        <a class="btn btn-secondary btn-sm" href="{{ route('users.impersonate', $user->id) }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="{{ __('Impersonate') }}" aria-label="{{ __('Impersonate') }}">
            <i class="ti ti-new-section"></i>
        </a>
        <a class="btn btn-info btn-sm" href="{{ route('user.phoneverified', $user->id) }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="{{ __('Phone Verified') }}">
            <i class="ti ti-message-circle"></i></a>
        <a class="btn btn-warning btn-sm" href="{{ route('user.phoneverified', $user->id) }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="{{ __('Phone Unverified') }}">
            <i class="ti ti-message-circle"></i></a>

        <a class="btn btn-info btn-sm" href="{{ route('user.verified', $user->id) }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="{{ __('Email Verified') }}">
            <i class="ti ti-mail"></i></a>
        <a class="btn btn-warning btn-sm" href="{{ route('user.verified', $user->id) }}" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="{{ __('Email Unverified') }}">
            <i class="ti ti-mail-forward"></i></a>
        <a class="btn btn-primary btn-sm" href="javascript:void(0);" id="edit-user"
            data-url="{{ route('users.edit', $user->id) }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="{{ __('Edit') }}"><i class="ti ti-edit"></i></a>
        {!! Form::open([
            'method' => 'DELETE',
            'route' => ['users.destroy', $user->id],
            'id' => 'delete-form-' . $user->id,
            'class' => 'd-inline',
        ]) !!}
        <a href="#" class="btn btn-danger btn-sm show_confirm" id="delete-form-{{ $user->id }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ __('Delete') }}"><i
                class="ti ti-trash"></i></a>
        {!! Form::close() !!}
</span>
