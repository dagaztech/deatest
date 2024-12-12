<?php echo Form::model($user, [
    'route' => ['users.update', $user->id],
    'method' => 'Put',
    'data-validate',
]); ?>

<div class="modal-body">
    <div class="row">
        <div class="form-group">
            <?php echo e(Form::label('name', __('Name'), ['class' => 'col-form-label'])); ?>

            <?php echo Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Enter name')]); ?>

        </div>
        <div class="form-group">
            <?php echo e(Form::label('email', __('Email'), ['class' => 'col-form-label'])); ?>

            <?php echo Form::text('email', null, [
                'class' => 'form-control',
                'required',
                'placeholder' => __('Enter email address'),
            ]); ?>

        </div>
    </div>
    <div class="form-group">
        <?php echo e(Form::label('password', __('Password'), ['class' => 'col-form-label'])); ?>

        <?php echo Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter password')]); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('confirm-password', __('Confirm Password'), ['class' => 'col-form-label'])); ?>

        <?php echo e(Form::password('confirm-password', ['class' => 'form-control', 'placeholder' => __('Enter confirm password')])); ?>

    </div>
    <div class="form-group mb-3">
        <?php echo e(Form::label('country_code', __('Country Code'), ['class' => 'd-block form-label'])); ?>

        <select id="country_code" name="country_code"class="form-control" data-trigger>
            <?php $__currentLoopData = \App\Core\Data::getCountriesList(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option data-kt-flag="<?php echo e($value['flag']); ?>"
                    <?php echo e($value['phone_code'] == $user->country_code ? 'selected' : ''); ?> value="<?php echo e($key); ?>">
                    +<?php echo e($value['phone_code']); ?> <?php echo e($value['name']); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="form-group mb-3">
        <?php echo e(Form::label('phone', __('Phone Number'), ['class' => 'form-label'])); ?>

        <?php echo Form::number('phone', null, [
            'autofocus' => '',
            'required' => true,
            'autocomplete' => 'off',
            'placeholder' => 'Enter phone Number',
            'class' => 'form-control',
        ]); ?>

    </div>
    <div class="form-group">
        <?php echo e(Form::label('roles', __('Role'), ['class' => 'col-form-label'])); ?>

        <?php echo Form::select('roles', $roles, $userRole, [
            'class' => 'form-select',
            'required',
            'id' => 'roles',
        ]); ?>

    </div>
</div>
<div class="modal-footer">
    <div class="float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
        <?php echo e(Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary'])); ?>

    </div>
</div>
<?php echo Form::close(); ?>

<?php /**PATH C:\xampp2\htdocs\dea-template-pwa-last\resources\views/users/edit.blade.php ENDPATH**/ ?>