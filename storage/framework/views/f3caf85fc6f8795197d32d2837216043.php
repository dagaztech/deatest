    <a href="<?php echo e(route('download.form.values.pdf', $formValue->id)); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Download')); ?>" class="btn btn-success btn-sm"
        data-toggle="tooltip"><i class="ti ti-file-download"></i></a>
    <a href="<?php echo e(route('form-values.show', $formValue->id)); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Show')); ?>" title="<?php echo e(__('View Survey')); ?>"
        class="btn btn-info btn-sm" data-toggle="tooltip"><i class="ti ti-eye"></i></a>
    <a href="<?php echo e(route('form-values.edit', $formValue->id)); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
         data-bs-original-title="<?php echo e(__('Edit')); ?>" title="<?php echo e(__('Edit Survey')); ?>"
        class="btn btn-primary btn-sm" data-toggle="tooltip"><i class="ti ti-edit"></i> </a>
    <?php echo Form::open([
        'method' => 'DELETE',
        'route' => ['form-values.destroy', $formValue->id],
        'id' => 'delete-form-' . $formValue->id,
        'class' => 'd-inline',
    ]); ?>

    <a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Delete')); ?>" id="delete-form-<?php echo e($formValue->id); ?>"><i class="ti ti-trash"></i></a>
    <?php echo Form::close(); ?>


<?php /**PATH C:\Users\andresmauriciogomezr\Documents\proyectos\dea-template-pwa\resources\views/form-value/action.blade.php ENDPATH**/ ?>