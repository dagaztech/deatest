@section('css')
    @include('layouts.includes.datatable-css')
@endsection

<!--{ !! $dataTable->table(['width' => '100%']) !!}-->

@section('scripts')
    @include('layouts.includes.datatable-js')
    {!! $dataTable->scripts() !!}
@endsection