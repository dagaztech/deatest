<?php echo Form::model($role, [
    'route' => ['roles.update', $role->id],
    'method' => 'Put',
    'data-validate',
]); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group">
            <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?>

            <?php echo e(Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter first name')])); ?>

        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

    </div>
</div>
<?php echo Form::close(); ?>

<?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/roles/edit.blade.php ENDPATH**/ ?>