
        <?php if($form->is_active): ?>
            <?php
                $hashids = new Hashids('', 20);
                $id = $hashids->encodeHex($form->id);
            ?>


            <a class="btn btn-success btn-sm copy_form" onclick="copyToClipboard('#copy-form-<?php echo e($form->id); ?>')"
                href="javascript:void(0)" id="copy-form-<?php echo e($form->id); ?>" data-bs-toggle="tooltip"
                data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Copy Form URL')); ?>"
                data-url="<?php echo e(route('forms.survey', $id)); ?>"><i class="ti ti-copy"></i></a>
                <?php endif; ?>
         
    <a class="btn btn-info btn-sm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Design Form')); ?>" href="<?php echo e(route('forms.design', $form->id)); ?>"><i
            class="ti ti-brush"></i></a>
    <a class="btn btn-primary btn-sm" href="<?php echo e(route('forms.edit', $form->id)); ?>" data-bs-toggle="tooltip"
        data-bs-placement="bottom" data-bs-original-title="<?php echo e(__('Edit Form')); ?>" id="edit-form"><i
            class="ti ti-edit"></i></a>

    <?php echo Form::open([
        'method' => 'DELETE',
        'route' => ['forms.destroy', $form->id],
        'id' => 'delete-form-' . $form->id,
        'class' => 'd-inline',
    ]); ?>

    <a href="#" class="btn btn-danger btn-sm show_confirm" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="<?php echo e(__('Delete')); ?>" id="delete-form-<?php echo e($form->id); ?>"><i
            class="mr-0 ti ti-trash"></i></a>
    <?php echo Form::close(); ?>



    <?php echo Form::open(['method' => 'POST', 'route' => ['forms.duplicate'], 'id' => 'duplicate-form-' . $form->id]); ?>

    <?php echo Form::hidden('form_id', $form->id, []); ?>

    <?php echo Form::close(); ?>

<?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/form/action.blade.php ENDPATH**/ ?>