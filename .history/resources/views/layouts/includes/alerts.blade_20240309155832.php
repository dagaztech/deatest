 <script>
     @if (session('failed'))
         show_toastr('¡Falló!', '{{ session('failed') }}', 'failed');
     @endif
     @if ($errors = session('errors'))
         @if (is_object($errors))
             @foreach ($errors->all() as $error)
                 show_toastr('¡Error!', '{{ $error }}', 'danger');
             @endforeach
         @else
             show_toastr('¡Error!', '{{ session('errors') }}', 'danger');
         @endif
     @endif
     @if (session('successful'))
         show_toastr('¡Exitosamente!', '{{ session('successful') }}', 'success');
     @endif
     @if (session('success'))
         show_toastr('¡Excelente!', '{{ session('success') }}', 'success');
     @endif
     @if (session('warning'))
         show_toastr('¡Atenicón!', '{{ session('warning') }}', 'warning');
     @endif
     @if (session('status'))
         show_toastr('¡Perfecto!', '{{ session('status') }}', 'info');
     @endif
 </script>
 <script>
     $(document).on('click', '.delete-action', function() {
         var form_id = $(this).attr('data-form-id')
         $.confirm({
             title: '{{ __('¡Alerta!') }}',
             conentt: '{{ __('¿ Estás seguro ?') }}',
             buttons: {
                 confirm: function() {
                     $("#" + form_id).submit();
                 },
                 cancel: function() {}
             }
         });
     });
 </script>
 <script>
     const sweetAlert = Swal.mixin({
         customClass: {
             confirmButton: 'btn btn-success m-1',
             cancelButton: 'btn btn-danger m-1'
         },
         buttonsStyling: false,
         title: '¿Estás seguro?',
         text: "Esta acción no se puede deshacer. ¿Quieres continuar?",
         icon: 'warning',
         showCancelButton: true,
         confirmButtonText: 'Siguiente Página',
         cancelButtonText: 'No',
         reverseButtons: true
     })
 </script>
