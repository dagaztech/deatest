
<?php $__env->startSection('title', $formValue->Form->title); ?>
<?php $__env->startSection('breadcrumb'); ?>
<header>
<title><?php echo e($formValue->Form->title); ?></title>
</header>
<style>
    table th {
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap.min.css" />
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
        <div class="section-body normal-width">
            <div class="row">
                <div class="card downloadss"  id="contenido">
                 
                    <div class="card-header" id="hedd">
                        <h5> <?php echo e($formValue->Form->title); ?>  </h5>
                    </div>
                  
                    <div class="card-body" id="contenidoa" style="overflow-x: scroll">
                        <div class="view-form-data">
                            <button class="btn btn-primary download-pdf-btn" onClick="javascript: document.getElementById('imprimir').imprimirPDF()">Descargar Reporte PDF</button> 
                            <div id="imprimir" class="row">

                                <table id="tabla2" class="table" style="border-style: solid; border-width: 3px; font-family: Arial, sans-serif; font-size: 14px; font-weight: normal; overflow: hidden; padding: 10px 5px; word-break: normal;border-color:black !important; margin-bottom:20px;">

                                    <thead>
                                        <tr style="border:3px solid #000 !important;">

                                           
                                            <?php
                                                $contados = 0;
                                            ?>

                                            <?php $__currentLoopData = $resultado[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                 <?php
                                                    if ($row->type == 'header'){

                                                        $row->label = "";
                                                    }

                                                    if (!isset($row->label)){

                                                        $row->label = "";
                                                    }

                                                    if (!isset($row->value)){

                                                        $row->value = "";
                                                    }
                                                ?>

                                               
                                                    


                                                <?php if(isset($row->label) && $row->type != 'paragraph' && $row->type != 'header' && $row->label != 'Salto de linea'): ?>

                                                        <?php if($contados == 0): ?>{
                                                            <td class="tg-0pky" style="border-right:#1px solid #fff !important;" >
                                                                <h3 style="text-transform:uppercase, font-weight:bold;font-size:32px;"width="80%"> <?php echo e($formValue->Form->title); ?></h3>
                                                                <p style="color:#000">

                                                                    <span>Fecha: <?php echo e($formValue->Form->updated_at); ?></span> | 
                                                                    <?php if($formValue->User): ?>
                                                                        <span><?php echo e($formValue->User->rol); ?></span>
                                                                    <?php endif; ?>
                                                                </p>
                                                            </td>
                                                        
                                                        <?php elseif($contados == 1): ?>{
                                                            <td class="tg-0pky" style="border-left:#1px solid #fff !important; text-align:right" width="20%">
                                                                <img src="https://dea.wearesmart.co/images/logo_footer.png" width="120px"/>
                                                            </td>
                                                        <?php else: ?>
                                                            <td style="display:none:">
                                                            </td>
                                                        <?php endif; ?>
                                                         
                                                         <?php
                                                            $contados ++;
                                                        ?>

                                                <?php endif; ?>

                                                



                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                          </tr>

                                    </thead>
                                </table>

                                <table id="tabla" class="table table-responsive">
                                    <thead>
                                        

                                        <tr>
                                            <?php $__currentLoopData = $resultado[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <?php
                                                            if ($row->type == 'header'){

                                                                $row->label = "";
                                                            }
                                                        ?>


                                                        <?php if(isset($row->label) && $row->type != 'paragraph' && $row->type != 'header' && $row->label != 'Salto de linea'): ?>

                                                    <th >
                                                        
                                                        <label>
                                                            <?php echo html_entity_decode($row->label); ?>

                                                        </label>

                                                    </th>
                                                <?php endif; ?>

                                                    
                                                    

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    </thead>


                                    <tbody>

                                        <?php $__currentLoopData = $resultado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arrady => $array): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                            <tr>
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


                                                         <?php if($row->label == 'Salto de linea'): ?>

                                                            <?php
                                                            continue;
                                                            ?>
                                                        <?php endif; ?>


                                                        <?php if($row->type == 'checkbox-group'): ?>
                                                           
                                                                <td>
                                                                    <div class="form-group">
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
                                                                </td>
                                                          
                                                        <?php elseif($row->type == 'file'): ?>
                                                           
                                                                <td>
                                                                    <div class="form-group">
                                                                        
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


                                                                                                <?php

                                                                                                if(is_int($row->value)){
                                                                                                    $row->value = array();

                                                                                                }

                                                                                                ?>



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
                                                                </td>
                                                           
                                                        <?php elseif($row->type == 'header'): ?>
                                                        <?php elseif($row->type == 'paragraph'): ?>
                                                           

                                                        <?php elseif($row->type == 'radio-group'): ?>
                                                           
                                                                <td>
                                                                    <div class="form-group">
                                                                        
                                                                        <p>
                                                                            <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php if(isset($options->selected)): ?>
                                                                                    <?php echo e($options->label); ?>

                                                                                <?php endif; ?>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </p>
                                                                    </div>
                                                                </td>
                                                         
                                                        <?php elseif($row->type == 'select'): ?>
                                                       
                                                                <td>
                                                                    <div class="form-group">

                                                                        <p>
                                                                            <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php if(isset($options->selected)): ?>
                                                                                    <?php echo e($options->label); ?>

                                                                                <?php endif; ?>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </p>
                                                                    </div>
                                                                </td>
                                                            
                                                        <?php elseif($row->type == 'autocomplete'): ?>
                                                  
                                                                <td>
                                                                    <div class="form-group">
                                                                        <p>
                                                                            <?php echo e($row->value); ?>

                                                                        </p>
                                                                    </div>
                                                                </td>
                                                           
                                                        <?php elseif($row->type == 'number'): ?>
                                                           
                                                                <td>
                                                                    <p>
                                                                        <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                                    </p>
                                                                </td>
                                                   
                                                        <?php elseif($row->type == 'text'): ?>
                                                           
                                                                <td>
                                                                    <div class="form-group">
                                                                        <?php if($row->subtype == 'color'): ?>
                                                                            <div class="p-2"
                                                                                style="background-color: <?php echo e($row->value); ?>;">
                                                                            </div>
                                                                        <?php else: ?>
                                                                            <p>
                                                                        

                                                                              <?php echo html_entity_decode($row->value); ?>

                                                                            </p>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </td>
                                                            
                                                        <?php elseif($row->type == 'date'): ?>
                                                    
                                                                <td>
                                                                    <div class="form-group">
                                                                        <p>
                                                                            <?php echo e(isset($row->value) ? date('d-m-Y', strtotime($row->value)) : ''); ?>

                                                                        </p>
                                                                    </div>
                                                                </td>
                                                          
                                                        <?php elseif($row->type == 'textarea'): ?>
                                                     
                                                                <td>
                                                                    <div class="form-group">
                                                                        <?php if($row->subtype == 'ckeditor'): ?>
                                                                            <?php echo isset($row->value) ? $row->value : ''; ?>

                                                                        <?php else: ?>
                                                                            <p>
                                                                                <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                                            </p>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </td>
                                                           
                                                        <?php elseif($row->type == 'starRating'): ?>
                                                  
                                                                <td>
                                                                    <div class="form-group">
                                                                        <?php
                                                                            $attr = ['class' => 'form-control'];
                                                                            if ($row->required) {
                                                                                $attr['required'] = 'required';
                                                                            }
                                                                            $value = isset($row->value) ? $row->value : 0;
                                                                            $noOfStar = isset($row->number_of_star) ? $row->number_of_star : 5;
                                                                        ?>
                                                                        <p>
                                                                        <div id="<?php echo e($row->name); ?>" class="starRating"
                                                                            data-value="<?php echo e($value); ?>"
                                                                            data-no_of_star="<?php echo e($noOfStar); ?>">
                                                                        </div>
                                                                        <input type="hidden" name="<?php echo e($row->name); ?>"
                                                                            value="<?php echo e($value); ?>">
                                                                        </p>
                                                                    </div>
                                                                </td>
                                                           
                                                        <?php elseif($row->type == 'SignaturePad'): ?>
                                                  
                                                                <td>
                                                                    <div class="form-group">
                                                                        <?php
                                                                            $attr = ['class' => 'form-control'];
                                                                            if ($row->required) {
                                                                                $attr['required'] = 'required';
                                                                            }
                                                                            $value = isset($row->value) ? $row->value : 0;
                                                                            $noOfStar = isset($row->number_of_star) ? $row->number_of_star : 5;
                                                                        ?>
                                                                        <?php if(property_exists($row, 'value')): ?>
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <img id="silas" src="<?php echo e(asset(Storage::url($row->value))); ?>">
                                                                                </div>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </td>
                                                            
                                                        <?php elseif($row->type == 'break'): ?>
                                                     
                                                                <td>
                                                                    <div class="form-group">
                                                                        <hr class="hr_border">
                                                                    </div>
                                                                </td>
                                                          
                                                        <?php elseif($row->type == 'location'): ?>
                                        
                                                                <td>
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('location_id', 'Location:'); ?>

                                                                        <iframe width="100%" height="260" frameborder="0"
                                                                            scrolling="no" marginheight="0" marginwidth="0"
                                                                            src="https://maps.google.com/maps?q=<?php echo e($row->value); ?>&hl=en&z=14&amp;output=embed">
                                                                        </iframe>
                                                                    </div>
                                                                </td>
                                                            
                                                        <?php elseif($row->type == 'video'): ?>
                                                      
                                                                <td>
                                                                    <div class="form-group">
                                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?><br>
                                                                        <a href="<?php echo e(route('selfie.image.download', $formValue->id)); ?>">
                                                                            <button class="btn btn-primary p-2"
                                                                                id="downloadButton"><?php echo e(__('Download Video')); ?></button></a>
                                                                    </div>
                                                                </td>
                                                            
                                                        <?php elseif($row->type == 'selfie'): ?>
                                                   
                                                                <td>
                                                                    <div class="col-12">
                                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?><br>
                                                                        <img
                                                                            src=" <?php echo e(Illuminate\Support\Facades\File::exists(Storage::path($row->value)) ? Storage::url($row->value) : Storage::url('app-logo/78x78.png')); ?>"class="img-responsive img-thumbnailss mb-2">
                                                                        <br>
                                                                        <a href="<?php echo e(route('selfie.image.download', $formValue->id)); ?>">
                                                                            <button class="btn btn-primary p-2"
                                                                                id="downloadButton"><?php echo e(__('Download Image')); ?></button></a>
                                                                    </div>
                                                                </td>
                                                            
                                                        <?php else: ?>
                                                            <td>
                                                                <div class="form-group">
                                                                    <?php echo e(Form::label($row->name, isset($row->label))); ?><?php if(isset($row->required)): ?>
                                                                        <span class="text-danger align-items-center">*</span>
                                                                    <?php endif; ?>
                                                                    <p>
                                                                        <?php echo e(isset($row->value) ? $row->value : ''); ?>

                                                                    </p>
                                                                </div>
                                                            </td>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </tbody>
                                    
                                </table>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    
                        <a href="/user-administrador/reportes-useradmin"
                            class="btn btn-secondary float-end"><?php echo e(__('Volver a Reportes')); ?></a> 
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
 <script>
    $.fn.dataTable.ext.errMode = 'none';
 </script>
   <script>
    // Redefinir la función alert para que no haga nada
    window.alert = function() {};
</script>

<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" ></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js" ></script>

    <script>

        $(document).ready(function(){

            // new DataTable('#tabla');
            // let table = new DataTable('#tabla');
            function getBase64Image(url, callback) {
                var img = new Image();
                img.crossOrigin = "anonymous";
                var x = img.onload = function () {
                    var canvas = document.createElement("canvas");
                    canvas.width =this.width;
                    canvas.height =this.height;
                    var ctx = canvas.getContext("2d");
                    ctx.drawImage(this, 0, 0);
                    //var dataURL = canvas.toDataURL("image/png");
                    var dataURL = canvas.toDataURL('data:image/png;base64,{base64encodedimage}');

                    callback(dataURL);
                    
                };
                img.src = url;
              }



            $('#tabla').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'excel',
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A2',

                    }
                ],'bInfo': false,
                
            } );


            HTMLElement.prototype.imprimirPDF = imprimirPDF;
            function imprimirPDF(query){
                

                var iframe = document.createElement('IFRAME');
                iframe.domain = document.domain;
                iframe.style.position = "absolute";
                iframe.style.top = "-10000px";
                document.body.appendChild(iframe);

                console.log(this.outerHTML)

                outerHtml = this.outerHTML.replace('<div class="dt-buttons"> <button class="dt-button buttons-excel buttons-html5 btn btn-primary download-pdf-btn" tabindex="0" aria-controls="tabla" type="button"><span>Descargar en Excel</span></button> | <button class="dt-button buttons-pdf buttons-html5 btn btn-primary download-pdf-btn" style="display:block !important" tabindex="0" aria-controls="tabla" type="button"><span>Descargar en PDF</span></button> | <div id="tabla_filter" class="dataTables_filter"><label for="buscador">Buscador:</label><input type="search" class="buscador" id="buscador" placeholder="Buscar para filtrar" aria-controls="tabla"></div></div>', ' ');
               

               outerHtml = outerHtml.replace(`{
                                                            
                                                        
                                                                                                                 
                                                         
                                                
                                                



                                                                                                 
                                               
                                                    


                                                
                                                        {`, " ");
                outerHtml = outerHtml.replace(`{ {`, " ");
                outerHtml = outerHtml.replace('{ {', " ");

                // console.log(outerHtml)

                iframe.contentDocument.open();

                var cssStyles = 
                '<style type="text/css">' +
                    'table {color: black; font-family:Arial,Helvetica,sans-serif;font-size:13px; text-align:center; print-color-adjust: exact;}'+
                    '.tg-0pky {border-right:#1px solid #fff !important; color:black !important;font-family:Arial,Helvetica,sans-serif;}'+
                    '.tg {border-collapse:collapse;border-spacing:0 !important;font-family:Arial,Helvetica,sans-serif;}' +
                    '.tg td, td{font-family:Arial,Helvetica,sans-serif;font-size:13px !important;text-align:center;' +
                      'overflow:hidden;padding:10px 5px;word-break:normal !important;}' +
                    '.tg th, th{font-family:Arial,Helvetica,sans-serif;font-size:12px !important;' +
                      'font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal !important;}' +
                    '.tg-bc6i, th{background:#329a9d !important;border-color:#cccccc;border-style:solid;border-width:1px;color:#ffffff !important;font-family:Arial,Helvetica,sans-serif;font-weight:bold;text-align:center;vertical-align:top !important;} ' +
                    '.tg-0pky{border-color:inherit;text-align:left;vertical-align:top !important;}' +
                    '.dataTables_paginate,.dt-buttons,.dataTables_filter{display: none !important;}'+
                    'tbody tr:nth-child(odd){background-color:#ddd;}'+
                    '@media print {body {-webkit-print-color-adjust: exact;}}'+
                '</style>';
                
                iframe.contentDocument.write(cssStyles + outerHtml);
                iframe.contentDocument.close();



                setTimeout(function(){
                    iframe.focus();
                    iframe.contentWindow.print();
                    iframe.parentNode.removeChild(iframe) ;// remove frame
                },3000); // wait for images to load inside iframe
                window.focus();
             }

            

             document.getElementById('imprimir').imprimirPDF()



        });
    </script>


<style>
    table, th, td, table.dataTable {
        border-collapse: collapse  !important;
      }
       #forms-table > thead > tr > th.sorting_desc{
        white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:1px;
      }
      
@media print {
    body {-webkit-print-color-adjust: exact;}
    }
    #imprimir{
        color:#fff;
    }
    .dt-buttons{
    width: 50%;
    float: left;
}
    .dt-button.buttons-html5{
        background: #00a7b8;
    border: none;
    font-size: 14px;
    text-transform: uppercase;
    float: left;
    margin-right: 1em;
    padding: 8px 15px;
    color: #fff;
    border-radius: 10px;
    
}div.dataTables_wrapper div.dataTables_filter {
    text-align: right;
    float: right;
    color: #000;
}
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/form-value/download.blade.php ENDPATH**/ ?>