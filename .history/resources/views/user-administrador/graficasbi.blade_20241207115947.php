@extends('layouts.main')

@section('title', 'Tablas y Gráficos Dinámicos')

@section('content')
<div class="section-body">
    <h3 class="text-center">Datos del Formulario</h3>

    <!-- Tabla Dinámica -->
    <table class="table table-bordered">
        <thead>
            <tr>
                @foreach ($columns as $column)
                    <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($tableData as $row)
                <tr>
                    <td>{{ $row['label'] }}</td>
                    <td>{{ $row['value'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Gráficos -->
    <div id="charts-container">
        @foreach ($resultado as $index => $row)
            <canvas id="chart-{{ $index }}" width="400" height="200"></canvas>
        @endforeach
    </div>
</div>

@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const resultados = @json($resultado);

    resultados.forEach((row, index) => {
        const ctx = document.getElementById('chart-' + index).getContext('2d');

        const labels = row.map(field => field.label);
        const data = row.map(field => field.value);

        new Chart(ctx, {
            type: 'bar', // Cambia según el tipo de gráfico que desees
            data: {
                labels: labels,
                datasets: [{
                    label: 'Valores',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
</script>
@endpush
@endsection
