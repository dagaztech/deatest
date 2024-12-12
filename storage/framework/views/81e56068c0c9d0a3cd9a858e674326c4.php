<?php $__env->startSection('css'); ?>
    <?php echo $__env->make('layouts.includes.datatable-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<!--{ !! $dataTable->table(['width' => '100%']) !!}-->

<p> Tabla de Historico en proceso...</p>
<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('layouts.includes.datatable-js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!--{ !! $dataTable->scripts() !!}-->
<?php $__env->stopSection(); ?><?php /**PATH C:\xampp2\htdocs\dea-template-pwa-last\resources\views/user-operativo/tabla-historicousuarios.blade.php ENDPATH**/ ?>