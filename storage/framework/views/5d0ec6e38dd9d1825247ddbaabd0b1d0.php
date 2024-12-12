<span>
        <a class="btn btn-secondary btn-sm" href="<?php echo e(route('users.impersonate', $user->id)); ?>" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Impersonate')); ?>" aria-label="<?php echo e(__('Impersonate')); ?>">
            <i class="ti ti-new-section"></i>
        </a>
        <a class="btn btn-info btn-sm" href="<?php echo e(route('user.phoneverified', $user->id)); ?>" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Phone Verified')); ?>">
            <i class="ti ti-message-circle"></i></a>
        <a class="btn btn-warning btn-sm" href="<?php echo e(route('user.phoneverified', $user->id)); ?>" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Phone Unverified')); ?>">
            <i class="ti ti-message-circle"></i></a>

        <a class="btn btn-info btn-sm" href="<?php echo e(route('user.verified', $user->id)); ?>" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Email Verified')); ?>">
            <i class="ti ti-mail"></i></a>
        <a class="btn btn-warning btn-sm" href="<?php echo e(route('user.verified', $user->id)); ?>" data-bs-toggle="tooltip"
            data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Email Unverified')); ?>">
            <i class="ti ti-mail-forward"></i></a>
        <a class="btn btn-primary btn-sm" href="javascript:void(0);" id="edit-user"
            data-url="<?php echo e(route('users.edit', $user->id)); ?>" data-bs-toggle="tooltip" data-bs-placement="bottom"
            data-bs-original-title="<?php echo e(__('Edit')); ?>"><i class="ti ti-edit"></i></a>
        <?php echo Form::open([
            'method' => 'DELETE',
            'route' => ['users.destroy', $user->id],
            'id' => 'delete-form-' . $user->id,
            'class' => 'd-inline',
        ]); ?>

        <a href="#" class="btn btn-danger btn-sm show_confirm" id="delete-form-<?php echo e($user->id); ?>"
            data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Delete')); ?>"><i
                class="ti ti-trash"></i></a>
        <?php echo Form::close(); ?>

</span>
<?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/users/action.blade.php ENDPATH**/ ?>