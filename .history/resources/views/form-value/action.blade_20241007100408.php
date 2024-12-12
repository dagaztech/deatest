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

    <!--PARA TRADUCIR BOTONES DE SUBMIT Y SIMILARES-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Selecciona todos los botones en la página
        const botones = document.querySelectorAll("button");
    
        // Diccionario de traducciones
        const traducciones = {
            "Next": "Siguiente",
            "Previous": "Anterior",
            "Submit": "Enviar",
            "Clear": "Limpiar",
            "Claro": "Limpiar"
        };
    
        // Recorre cada botón y verifica si su texto está en inglés
        botones.forEach(function(boton) {
            const textoBoton = boton.textContent.trim();
            
            // Si el texto del botón está en el diccionario, lo traduce
            if (traducciones[textoBoton]) {
                boton.textContent = traducciones[textoBoton];
            }
        });
    });
    </script>