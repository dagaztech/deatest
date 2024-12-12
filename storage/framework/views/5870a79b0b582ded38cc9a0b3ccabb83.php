 <script>
     <?php if(session('failed')): ?>
         show_toastr('¡Falló!', '<?php echo e(session('failed')); ?>', 'failed');
     <?php endif; ?>
     <?php if($errors = session('errors')): ?>
         <?php if(is_object($errors)): ?>
             <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 show_toastr('¡Error!', '<?php echo e($error); ?>', 'danger');
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php else: ?>
             show_toastr('¡Error!', '<?php echo e(session('errors')); ?>', 'danger');
         <?php endif; ?>
     <?php endif; ?>
     <?php if(session('successful')): ?>
         show_toastr('¡Exitosamente!', '<?php echo e(session('successful')); ?>', 'success');
     <?php endif; ?>
     <?php if(session('success')): ?>
         show_toastr('¡Excelente!', '<?php echo e(session('success')); ?>', 'success');
     <?php endif; ?>
     <?php if(session('warning')): ?>
         show_toastr('¡Atenicón!', '<?php echo e(session('warning')); ?>', 'warning');
     <?php endif; ?>
     <?php if(session('status')): ?>
         show_toastr('¡Perfecto!', '<?php echo e(session('status')); ?>', 'info');
     <?php endif; ?>
 </script>
 <script>
     $(document).on('click', '.delete-action', function() {
         var form_id = $(this).attr('data-form-id')
         $.confirm({
             title: '<?php echo e(__('¡Alerta!')); ?>',
             conentt: '<?php echo e(__('¿ Estás seguro ?')); ?>',
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
<?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/layouts/includes/alerts.blade.php ENDPATH**/ ?>