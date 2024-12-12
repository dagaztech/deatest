@section('css')
    @include('layouts.includes.datatable-css')
@endsection

<!--{ !! $dataTable->table(['width' => '100%']) !!}-->

<p> Tabla de Historico en proceso...</p>
@section('scripts')
    @include('layouts.includes.datatable-js')
    <!--{ !! $dataTable->scripts() !!}-->
@endsection