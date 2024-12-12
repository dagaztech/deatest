@section('css')
    @include('layouts.datatable-css')
@endsection

{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatable-js')
    {!! $dataTable->scripts() !!}
@endsection