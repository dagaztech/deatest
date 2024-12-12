
<?php $__env->startSection('title', 'Ver Formularios'); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10"><?php echo e(__('Ver Formularios')); ?></h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><?php echo Html::link(route('home'), __('Panel de Control'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo Html::link(route('forms.index'), __('Formularios'), ['']); ?></li>
            <li class="breadcrumb-item"><?php echo e(__('Ver Formularios')); ?></li>
        </ul>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="section-body">
            <div class="row">
               <!-- @ if (!empty($formValue->Form->logo))
                    <div class="mb-2 text-center gallery gallery-md">
                        <img id="app-dark-logo" class="float-none gallery-item"
                            src="{ { Storage::exists($formValue->Form->logo) ? Storage::url($formValue->Form->logo) : Storage::url('not-exists-data-images/78x78.png') }}">
                    </div>
                @ endif-->
                <div class="card col-md-6 mx-auto"  id="contenido">
                    <div class="card-header" id="hedd">
                        <h5> <?php echo e($formValue->Form->title); ?>


                        </h5>
                    </div>
                    
                    <div class="card-body" id="contenido">
                        <div class="view-form-data">
                            <div class="row">
                                <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            // $fieldHidden = false;
                                            // if (in_array($row->name, $hideFields)) {
                                            //     $fieldHidden = true;
                                            // }
                                            if (!isset($row->label)) {
                                                        $row->label = '';
                                                    }
                                        ?>
                                        <?php if($row->type == 'checkbox-group'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <p>
                                                        <ul>
                                                            <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(isset($options->selected)): ?>
                                                                    <li>
                                                                        <label><?php echo e($options->label); ?></label>
                                                                    </li>
                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </ul>
                                                        </p>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'file'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <p>
                                                            <?php if(property_exists($row, 'value')): ?>
                                                                <?php if($row->value): ?>
                                                                    <?php
                                                                        $allowed_extensions = ['pdf', 'pdfa', 'fdf', 'xdp', 'xfa', 'pdx', 'pdp', 'pdfxml', 'pdxox', 'xlsx', 'csv', 'xlsm', 'xltx', 'xlsb', 'xltm', 'xlw'];
                                                                    ?>
                                                                    <?php if($row->multiple): ?>
                                                                        <div class="row">
                                                                            <?php if(App\Facades\UtilityFacades::getsettings('storage_type') == 'local'): ?>
                                                                                <?php $__currentLoopData = $row->value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <div class="col-6">
                                                                                        <?php
                                                                                            $fileName = explode('/', $img);
                                                                                            $fileName = end($fileName);
                                                                                        ?>
                                                                                        <?php if(in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                            <?php
                                                                                                $fileName = explode('/', $img);
                                                                                                $fileName = end($fileName);
                                                                                            ?>
                                                                                            <a class="my-2 btn btn-info"
                                                                                                href="<?php echo e(asset('storage/app/' . $img)); ?>"
                                                                                                type="image"
                                                                                                download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                        <?php else: ?>
                                                                                            <img src="<?php echo e(Storage::exists($img) ? asset('storage/app/' . $img) : Storage::url('not-exists-data-images/78x78.png')); ?>"
                                                                                                class="mb-2 img-responsive img-thumbnail">
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php else: ?>
                                                                                <?php $__currentLoopData = $row->value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <div class="col-6">
                                                                                        <?php
                                                                                            $fileName = explode('/', $img);
                                                                                            $fileName = end($fileName);
                                                                                        ?>
                                                                                        <?php if(in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                            <?php
                                                                                                $fileName = explode('/', $img);
                                                                                                $fileName = end($fileName);
                                                                                            ?>
                                                                                            <a class="my-2 btn btn-info"
                                                                                                href="<?php echo e(Storage::url($img)); ?>"
                                                                                                type="image"
                                                                                                download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                        <?php else: ?>
                                                                                            <img src="<?php echo e(Storage::url($img)); ?>"
                                                                                                class="mb-2 img-responsive img-thumbnail">
                                                                                        <?php endif; ?>
                                                                                    </div>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="row">
                                                                            <div class="col-6">
                                                                                <?php if($row->subtype == 'fineuploader'): ?>
                                                                                    <?php if(App\Facades\UtilityFacades::getsettings('storage_type') == 'local'): ?>
                                                                                        <?php if($row->value[0]): ?>
                                                                                            <?php $__currentLoopData = $row->value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                <?php
                                                                                                    $fileName = explode('/', $img);
                                                                                                    $fileName = end($fileName);
                                                                                                ?>
                                                                                                <?php if(in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                                    <a class="my-2 btn btn-info"
                                                                                                        href="<?php echo e(asset('storage/app/' . $img)); ?>"
                                                                                                        type="image"
                                                                                                        download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                                <?php else: ?>
                                                                                                    <img src="<?php echo e(Storage::exists($img) ? asset('storage/app/' . $img) : Storage::url('not-exists-data-images/78x78.png')); ?>"
                                                                                                        class="mb-2 img-responsive img-thumbnail">
                                                                                                <?php endif; ?>
                                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                        <?php endif; ?>
                                                                                    <?php else: ?>
                                                                                        <?php if($row->value[0]): ?>
                                                                                            <?php $__currentLoopData = $row->value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                                <?php
                                                                                                    $fileName = explode('/', $img);
                                                                                                    $fileName = end($fileName);
                                                                                                ?>
                                                                                                <?php if(in_array(pathinfo($img, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                                    <a class="my-2 btn btn-info"
                                                                                                        href="<?php echo e(Storage::url($img)); ?>"
                                                                                                        type="image"
                                                                                                        download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                                <?php else: ?>
                                                                                                    <img src="<?php echo e(Storage::url($img)); ?>"
                                                                                                        class="mb-2 img-responsive img-thumbnail">
                                                                                                <?php endif; ?>
                                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                        <?php endif; ?>
                                                                                    <?php endif; ?>
                                                                                <?php else: ?>
                                                                                    <?php if(App\Facades\UtilityFacades::getsettings('storage_type') == 'local'): ?>
                                                                                        <?php if(in_array(pathinfo($row->value, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                            <?php
                                                                                                $fileName = explode('/', $row->value);
                                                                                                $fileName = end($fileName);
                                                                                            ?>
                                                                                            <a class="my-2 btn btn-info"
                                                                                                href="<?php echo e(asset('storage/app/' . $row->value)); ?>"
                                                                                                type="image"
                                                                                                download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                        <?php else: ?>
                                                                                            <img src="<?php echo e(Storage::exists($row->value) ? asset('storage/app/' . $row->value) : Storage::url('not-exists-data-images/78x78.png')); ?>"
                                                                                                class="mb-2 img-responsive img-thumbnailss">
                                                                                        <?php endif; ?>
                                                                                    <?php else: ?>
                                                                                        <?php if(in_array(pathinfo($row->value, PATHINFO_EXTENSION), $allowed_extensions)): ?>
                                                                                            <?php
                                                                                                $fileName = explode('/', $row->value);
                                                                                                $fileName = end($fileName);
                                                                                            ?>
                                                                                            <a class="my-2 btn btn-info"
                                                                                                href="<?php echo e(Storage::url($row->value)); ?>"
                                                                                                type="image"
                                                                                                download=""><?php echo substr($fileName, 0, 30) . (strlen($fileName) > 30 ? '...' : ''); ?></a>
                                                                                        <?php else: ?>
                                                                                            <img src="<?php echo e(Storage::url($row->value)); ?>"
                                                                                                class="mb-2 img-responsive img-thumbnailss">
                                                                                        <?php endif; ?>
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'header'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <<?php echo e($row->subtype); ?>>
                                                            <?php echo html_entity_decode($row->label); ?>

                                                            </<?php echo e($row->subtype); ?>>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'paragraph'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <<?php echo e($row->subtype); ?>>
                                                            <?php echo html_entity_decode($row->label); ?>

                                                            </<?php echo e($row->subtype); ?>>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'radio-group'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <p>
                                                            <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(isset($options->selected)): ?>
                                                                    <?php echo e($options->label); ?>

                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'select'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>

                                                        <p>
                                                            <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(isset($options->selected)): ?>
                                                                    <?php echo e($options->label); ?>

                                                                <?php endif; ?>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'autocomplete'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <p>
                                                            <?php echo e($row->value); ?>

                                                        </p>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'number'): ?>
                                            
                                                <div class="col-12">
                                                    <b><?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                    </b>
                                                    <p>
                                                        <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                    </p>
                                                </div>
                                            
                                        <?php elseif($row->type == 'text'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if($row->subtype == 'color'): ?>
                                                            <div class="p-2"
                                                                style="background-color: <?php echo e($row->value); ?>;">
                                                            </div>
                                                        <?php else: ?>
                                                            <p>
                                                                <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'date'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <p>
                                                            <?php echo e(isset($row->value) ? date('d-m-Y', strtotime($row->value)) : ''); ?>

                                                        </p>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'textarea'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if($row->subtype == 'ckeditor'): ?>
                                                            <?php echo isset($row->value) ? $row->value : ''; ?>

                                                        <?php else: ?>
                                                            <p>
                                                                <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'starRating'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php
                                                            $attr = ['class' => 'form-control'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                            }
                                                            $value = isset($row->value) ? $row->value : 0;
                                                            $noOfStar = isset($row->number_of_star) ? $row->number_of_star : 5;
                                                        ?>
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <p>
                                                        <div id="<?php echo e($row->name); ?>" class="starRating"
                                                            data-value="<?php echo e($value); ?>"
                                                            data-no_of_star="<?php echo e($noOfStar); ?>">
                                                        </div>
                                                        <input type="hidden" name="<?php echo e($row->name); ?>"
                                                            value="<?php echo e($value); ?>">
                                                        </p>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'SignaturePad'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php
                                                            $attr = ['class' => 'form-control'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                            }
                                                            $value = isset($row->value) ? $row->value : 0;
                                                            $noOfStar = isset($row->number_of_star) ? $row->number_of_star : 5;
                                                        ?>
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(property_exists($row, 'value')): ?>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <img id="silas" src="<?php echo e(asset(Storage::url($row->value))); ?>">
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'break'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <hr class="hr_border">
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'location'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo Form::label('location_id', 'Location:'); ?>

                                                        <iframe width="100%" height="260" frameborder="0"
                                                            scrolling="no" marginheight="0" marginwidth="0"
                                                            src="https://maps.google.com/maps?q=<?php echo e($row->value); ?>&hl=en&z=14&amp;output=embed">
                                                        </iframe>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'video'): ?>
                                            
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?><br>
                                                        <a href="<?php echo e(route('selfie.image.download', $formValue->id)); ?>">
                                                            <button class="btn btn-primary p-2"
                                                                id="downloadButton"><?php echo e(__('Download Video')); ?></button></a>
                                                    </div>
                                                </div>
                                            
                                        <?php elseif($row->type == 'selfie'): ?>
                                            
                                                <div class="row">
                                                    <div class="col-12">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?><br>
                                                        <img
                                                            src=" <?php echo e(Illuminate\Support\Facades\File::exists(Storage::path($row->value)) ? Storage::url($row->value) : Storage::url('app-logo/78x78.png')); ?>"class="img-responsive img-thumbnailss mb-2">
                                                        <br>
                                                        <a href="<?php echo e(route('selfie.image.download', $formValue->id)); ?>">
                                                            <button class="btn btn-primary p-2"
                                                                id="downloadButton"><?php echo e(__('Download Image')); ?></button></a>
                                                    </div>
                                                </div>
                                            
                                        <?php else: ?>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <?php echo e(Form::label($row->name, isset($row->label))); ?><?php if(isset($row->required)): ?>
                                                        <span class="text-danger align-items-center">*</span>
                                                    <?php endif; ?>
                                                    <p>
                                                        <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                    </p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="javascript:javascript:history.go(-1)"
                            class="btn btn-secondary float-end"><?php echo e(__('Back')); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('style'); ?>
    <link href="<?php echo e(asset('vendor/jqueryform/css/jquery.rateyo.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('vendor/jqueryform/js/jquery.rateyo.min.js')); ?>"></script>
    <script>
        var $starRating = $('.starRating');
        if ($starRating.length) {
            $starRating.each(function() {
                var val = $(this).attr('data-value');
                var noOfStar = $(this).attr('data-no_of_star');
                if (noOfStar == 10) {
                    val = val / 2;
                }
                $(this).rateYo({
                    rating: val,
                    readOnly: true,
                    numStars: noOfStar
                })
            });
        }
    </script>


<!-- <<script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.0/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

<script
src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
crossorigin="anonymous"
referrerpolicy="no-referrer"
></script>


<script src="https://raw.githubusercontent.com/parallax/jsPDF/master/src/modules/png_support.js"></script>

    <script>

        $(document).ready(function(){

            //$('img').remove()


            // const elemento = document.getElementById('contenido'); // Asegúrate de que este ID corresponda al de tu elemento
            // html2canvas(elemento).then(canvas => {
            //     const imgData = canvas.toDataURL('image/png');
            //     const pdf = new jsPDF({
            //         orientation: 'portrait',
            //         unit: 'pt',
            //         format: [canvas.width, canvas.height]
            //     });
            //     pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
            //     pdf.save("archivo.pdf");
            // });


                // var pdf = new jsPDF({
                //      orientation: 'p',
                //      unit: 'mm',
                //      format: 'a5',
                //      putOnlyUsedFonts:true
                //      });
                //  pdf.text("Generate a PDF with JavaScript", 20, 20);
                //  pdf.text("published on APITemplate.io", 20, 30);
                //  pdf.addPage();
                //  pdf.text(20, 20, 'The second page');
                //  pdf.save('jsPDF_2Pages.pdf');





                 // const element = document.getElementById('contenido');
                 //   var opt = {
                 //      margin:       1,
                 //      filename:     'html2pdf_example.pdf',
                 //      // image:        { type: 'jpeg', quality: 0.98 },
                 //      html2canvas:  { scale: 2 },
                 //      jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                 //    };
                 //    html2pdf().set(opt).from(element).save();


                    // console.log(element)




                    // html2canvas(document.getElementById('contenido')).then((canvas) => {
                    //     const base64image = canvas.toDataURL('image/png');
                    //     const pdf = new jsPDF('p', 'px', [canvas.width, canvas.height]);
                    //     pdf.addImage(base64image, 'PNG', 0, 0, canvas.width, canvas.height);
                    //     pdf.save('attributes-results.pdf');

                    //     downloadButton.textContent = originalButtonText;
                    //   }).catch((error) => {
                    //     console.error('An error occurred:', error);
                    //     downloadButton.textContent = originalButtonText;
                    //   });


            // var contador = 1
            // $("img").each(function(e, ee){
            //     console.log(ee)
            //     ee.id = "aa"+contador
            //     contador = contador + 1
            // })


            // setTimeout(function(e){


            var doc = new jsPDF();          
            var elementHandler = {
              '#silas': function (element, renderer) {
                alert("")
                return true;
              }
            };

            

            var source = window.document.getElementById("contenido");
            doc.fromHTML(
                source,
                15,
                15,
                {
                  'width': 180,'elementHandlers': elementHandler
                });

            //doc.output("dataurlnewwindow");

            console.log($("img"))

            


            // }, 2000)


        });
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\dea-template-pwa-last\resources\views/form-value/view.blade.php ENDPATH**/ ?>