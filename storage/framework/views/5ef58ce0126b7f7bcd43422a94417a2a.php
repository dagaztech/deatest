  
    <a class="btn btn-primary btn-sm edit-role" href="javascript:void(0);" id="edit-role"
        data-url="roles/<?php echo e($role->id); ?>/edit" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Permissions')); ?>"><i class="ti ti-edit"></i></a>
    <?php echo Form::open([
        'method' => 'DELETE',
        'route' => ['roles.destroy', $role->id],
        'id' => 'delete-form-' . $role->id,
        'class' => 'd-inline',
    ]); ?>

    <a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Delete')); ?>" id="delete-form-<?php echo e($role->id); ?>"><i
            class="ti ti-trash"></i></a>
    <?php echo Form::close(); ?>

<?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/roles/action.blade.php ENDPATH**/ ?>