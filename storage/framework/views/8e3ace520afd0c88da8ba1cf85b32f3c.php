
<?php $__env->startSection('title', __('Editar Notificación por Email')); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Editar Notificación por Email')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Panel de Control'), []); ?></li>
            <li class="breadcrumb-item"><?php echo Html::link(route('mailtemplate.index'), __('Notificaciones por Email'), []); ?> </li>
            <li class="breadcrumb-item active"><?php echo e(__('Editar Notificación por Email')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="layout-px-spacing row">
        <div id="basic" class="mx-auto col-lg-6 layout-spacing">
            <div class="statbox card box box-shadow">
                <div class="card-header">
                    <h5><?php echo e(__('Editar Notificación por Email')); ?></h5>
                </div>
                <?php echo Form::model($mailtemplate, [
                    'route' => ['mailtemplate.update', $mailtemplate->id],
                    'method' => 'PUT',
                    'data-validate',
                ]); ?>

                <div class="card-body">
                    <div class="row">
                        <div class="mx-auto col-lg-12 col-12">
                            <div class="form-group">
                                <?php echo e(Form::label('variables', __('Variables '), ['class' => 'form-label fw-bolder text-dark fs-6'])); ?>

                                <?php $__currentLoopData = $mailtemplate->variables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variables): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="fw-bolder text-dark fs-6">{{ <?php echo $variables; ?> }}</span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('mailable', __('Mailable'), ['class' => 'form-label'])); ?>

                                <?php echo Form::text('mailable', null, ['placeholder' => 'App\Mail\TestMail', 'class' => 'form-control', 'readonly']); ?>

                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('subject', __('Subject'), ['class' => 'form-label'])); ?>

                                <?php echo Form::text('subject', null, [
                                    'placeholder' => 'readonly',
                                    'class' => 'form-control',
                                ]); ?>

                            </div>
                            <div class="form-group">
                                <?php echo e(Form::label('html_template', __('Html Template'), ['class' => 'form-label'])); ?>

                                <?php echo Form::textarea('html_template', null, [
                                    'placeholder' => '',
                                    'class' => 'form-control',
                                ]); ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="text-end">
                        <?php echo Html::link(route('mailtemplate.index'), __('Cancel'), ['class' => 'btn btn-secondary']); ?>

                        <?php echo e(Form::button(__('Save'), ['type' => 'submit','class' => 'btn btn-primary'])); ?>

                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script src="<?php echo e(asset('vendor/ckeditor/ckeditor.js')); ?>"></script>
    <script>
        CKEDITOR.replace('html_template', {
            filebrowserUploadUrl: "<?php echo e(route('ckeditor.upload', ['_token' => csrf_token()])); ?>",
            filebrowserUploadMethod: 'form'
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/mailtemplete/edit.blade.php ENDPATH**/ ?>