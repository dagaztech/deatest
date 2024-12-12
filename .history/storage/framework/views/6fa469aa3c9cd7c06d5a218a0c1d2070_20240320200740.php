
<?php
    use App\Facades\UtilityFacades;
    use App\Models\Role;
    use App\Models\AssignFormsRoles;
    use App\Models\AssignFormsUsers;
?>
<?php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($form->id);
?>

<div class="blue-header-bar">
    <div class="site-header header-style-one">
       <div class="main-navigationbar">
          <div class="container">
             <div class="navigation-row d-flex align-items-center ">
                <nav class="menu-items-col d-flex align-items-center justify-content-between bluebar-items">
                   <div class="logo-col">
                      <h1>
                         <a href="/home" tabindex="0">
                         <img src="../../images/logo.png" class="mainlogo">
                         </a>
                      </h1>
                   </div>
                   <div class="menu-item-right-col d-flex align-items-center justify-content-between">
                      <div class="menu-right-col">
                         <ul class=" d-flex align-items-center">
                            <li>
                               <div class="alcaldia_menu_top">
                                  <div class="iconosmed_"><img src="../../images/alcaldiaFooter.png" width="35" height="35"></div>
                                  <div class="dronwalcaldia_">
                                     <div class="titulalcaldia_">
                                        Alcaldía de Medellín
                                     </div>
                                  </div>
                               </div>
                            </li>
                         </ul>
                      </div>
                   </div>
                </nav>
             </div>
          </div>
       </div>
    </div>
  </div>
<!-- Mobile menu start here -->
        <div class="mobile-container public-form">
            <div class="mobile-menu-wrapper">
               <div class="mobile-menu-bar">
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-md-4 colsp">
                           <a href="javascript:history.back()" alt="Volver"><img src="../../images/FlechaIzq.png" alt="Volver" /></a>
                        </div>
                        <div class="col-md-4 text-center colsp colsp25">
                           <img src="../../images/logo-hor-AlcaldiaMedellin.png" alt="Logo Alcaldía de Medellín" />
                        </div>
                        <div class="col-md-4 tri-wrapper">
                           <div class="row">
                              <div class="col-md-4">
                                <div class="mobile-login-btn  text-center">
                                    <?php if(\Auth::guard('api')->user()->rol == "Usuario operador 1"): ?>
                                    <a href="<?php echo e(route('user-operador1.index')); ?>" class="top-menu-items" id="home-btn"></a>
                                    <?php elseif(\Auth::guard('api')->user()->rol == "Usuario operador 2"): ?>
                                    <a href="<?php echo e(route('user-operador2.index')); ?>" class="top-menu-items" id="home-btn"></a>
                                    <?php elseif(\Auth::guard('api')->user()->rol == "Usuario consulta E"): ?>
                                    <a href="<?php echo e(route('user-consultaentidad.index')); ?>" class="top-menu-items" id="home-btn"></a>
                                    <?php elseif(\Auth::guard('api')->user()->rol == "Consulta SSM"): ?>
                                    <a href="<?php echo e(route('user-consultassm.index')); ?>" class="top-menu-items" id="home-btn"></a>
                                    <?php elseif(\Auth::guard('api')->user()->rol == "Operativo SSM"): ?>
                                    <a href="<?php echo e(route('user-operativo.index')); ?>" class="top-menu-items" id="home-btn"></a>
                                    <?php else: ?>
                                    <a href="<?php echo e(route('user-administrador.index')); ?>" class="top-menu-items" id="home-btn"></a>
                                    <?php endif; ?>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="mobile-login-btn  text-center">
                                    <a href="<?php echo e(route('profile.index')); ?>" class="dropdown-item top-menu-items" id="user-btn">
                                   </a>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="mobile-login-btn  text-center">
                                    <a href="<?php echo e(route('logout')); ?>"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                    class="dropdown-item top-menu-items" id="logout-btn">
                                </a>
                                <?php echo Form::open([
                                    'route' => ['logout'],
                                    'method' => 'POST',
                                    'id' => 'logout-form',
                                    'class' => 'd-none',
                                ]); ?>

                                <?php echo Form::close(); ?>

                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
<!-- Mobile menu end here -->
<div class="section-body normal-width">
   
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
            <?php if(!empty($form->logo)): ?>
                <div class="mb-2 text-center gallery gallery-md">
                    <img id="app-dark-logo" class="float-none gallery-item"
                        src="<?php echo e(isset($form->logo) ? Storage::url($form->logo) : Storage::url('/not-exists-data-images/78x78.png')); ?>">
                </div>
            <?php endif; ?>
            <?php if(session()->has('success')): ?>

            
         
                <div class="card">                 
                    <div class="card-header">
    <h5 class="text-center w-100"><?php echo e($form->title); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center gallery" id="success_loader">
                            <img src="<?php echo e(asset('assets/images/success.gif')); ?>" />
                            <br>
                            <br>
                            <h2 class="w-100 "><?php echo e(session()->get('success')); ?></h2>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card">
                    <?php
                        $formRules = App\Models\formRule::where('form_id', $form->id)->get();
                        // foreach ($formRules as $formRule) {
                        //     $ifJsonArray = json_decode($formRule->if_json, true);
                        //     $thenJsonArray = json_decode($formRule->then_json, true);
                        // }
                    ?>
                    <div class="card-header">
                        <h5 class="text-center w-100"><?php echo e($form->title); ?></h5>
                    </div>
                    <div class="card-body form-card-body">
 <!--Mostrar popups-->
     <button type="button" class="btn btn-primary open-info modal-link" id="showanextec2" style="display:none">
        <img src="../../images/info.png" alt="Abrir modal">
        </button>
     <button type="button" class="btn btn-primary open-info modal-link2" id="showanextec3" style="display:none">
        <img src="../../images/info.png" alt="Abrir modal">
     </button>
<!--Fin de popups-->

                        <form action="<?php echo e(route('forms.fill.store', $form->id)); ?>" method="POST"
                            enctype="multipart/form-data" id="fill-form">
                            <?php echo method_field('PUT'); ?>
                            <?php if(isset($array)): ?>
                                <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="tab">
                                        <div class="row">
                                            <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row_key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    if (isset($row->column)) {
                                                        if ($row->column == 1) {
                                                            $col = 'col-12 step-' . $keys;
                                                        } elseif ($row->column == 2) {
                                                            $col = 'col-6 step-' . $keys;
                                                        } elseif ($row->column == 3) {
                                                            $col = 'col-4 step-' . $keys;
                                                        }
                                                    } else {
                                                        $col = 'col-12 step-' . $keys;
                                                    }
                                                    if (!isset($row->label)) {
                                                        $row->label = 'tab wrap';
                                                    }
                                                ?>
                                                <?php if($row->type == 'checkbox-group'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name="<?php echo e($row->name); ?>">
                                                        <label for="<?php echo e($row->name); ?>"
                                                            class="d-block form-label"><?php echo html_entity_decode($row->label); ?>

                                                            <?php if($row->required): ?>
                                                                <span class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                            <?php if(isset($row->description)): ?>
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="<?php echo e($row->description); ?>">
                                                                    ?
                                                                </span>
                                                            <?php endif; ?>
                                                        </label>
                                                        <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $attr = ['class' => 'form-check-input', 'id' => $row->name . '_' . $key];
                                                                $attr['name'] = $row->name . '[]';
                                                                if ($row->required) {
                                                                    $attr['required'] = 'required';
                                                                    $attr['class'] = $attr['class'] . ' required';
                                                                }
                                                                if ($row->inline) {
                                                                    $class = 'form-check form-check-inline col-4 ';
                                                                    if ($row->required) {
                                                                        $attr['class'] = 'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label mb-0 ml-1';
                                                                } else {
                                                                    $class = 'form-check';
                                                                    if ($row->required) {
                                                                        $attr['class'] = 'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label';
                                                                }
                                                            ?>
                                                            <div class="<?php echo e($class); ?>">
                                                                <?php echo e(Form::checkbox($row->name, $options->value, isset($options->selected) && $options->selected == 1 ? true : false, $attr)); ?>

                                                                <label class="<?php echo e($l_class); ?>"
                                                                    for="<?php echo e($row->name . '_' . $key); ?>"><?php echo e($options->label); ?></label>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($row->required): ?>
                                                            <div class=" error-message required-checkbox"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'file'): ?>
                                                    <?php
                                                        $attr = [];
                                                        $attr['class'] = 'form-control upload';
                                                        if ($row->multiple) {
                                                            $maxupload = 10;
                                                            $attr['multiple'] = 'true';
                                                            if ($row->subtype != 'fineuploader') {
                                                                $attr['name'] = $row->name . '[]';
                                                            }
                                                        }
                                                        if ($row->required && (!isset($row->value) || empty($row->value))) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        if ($row->subtype == 'fineuploader') {
                                                            $attr['class'] = $attr['class'] . ' ' . $row->name;
                                                        }
                                                    ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name="<?php echo e($row->name); ?>">
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php if($row->subtype == 'fineuploader'): ?>
                                                            <div class="dropzone" id="<?php echo e($row->name); ?>"
                                                                data-extention="<?php echo e($row->file_extention); ?>">
                                                            </div>
                                                            <?php echo $__env->make('form.js.dropzone', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                            <?php echo Form::hidden($row->name, null, $attr); ?>

                                                        <?php else: ?>
                                                            <?php echo e(Form::file($row->name, $attr)); ?>

                                                        <?php endif; ?>
                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-file"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'header'): ?>
                                                    <?php
                                                        $class = '';
                                                        if (isset($row->className)) {
                                                            $class = $class . ' ' . $row->className;
                                                        }
                                                    ?>
                                                    <div class="<?php echo e($col); ?>">
                                                        <<?php echo e($row->subtype); ?> class="<?php echo e($class); ?>">
                                                            <?php echo html_entity_decode($row->label); ?>

                                                            </<?php echo e($row->subtype); ?>>
                                                    </div>
                                                <?php elseif($row->type == 'paragraph'): ?>
                                                    <?php
                                                        $class = '';
                                                        if (isset($row->className)) {
                                                            $class = $class . ' ' . $row->className;
                                                        }
                                                    ?>
                                                    <div class="<?php echo e($col); ?>">
                                                        <<?php echo e($row->subtype); ?> class="<?php echo e($class); ?>">
                                                            <?php echo html_entity_decode($row->label); ?>

                                                            </<?php echo e($row->subtype); ?>>
                                                    </div>
                                                <?php elseif($row->type == 'radio-group'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <label for="<?php echo e($row->name); ?>"
                                                            class="d-block form-label"><?php echo html_entity_decode($row->label); ?>

                                                            <?php if($row->required): ?>
                                                                <span class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                            <?php if(isset($row->description)): ?>
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="<?php echo e($row->description); ?>">
                                                                    ?
                                                                </span>
                                                            <?php endif; ?>
                                                        </label>
                                                        <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                if ($row->required) {
                                                                    $attr['required'] = 'required';
                                                                    $attr = ['class' => 'form-check-input required', 'required' => 'required', 'id' => $row->name . '_' . $key];
                                                                } else {
                                                                    $attr = ['class' => 'form-check-input', 'id' => $row->name . '_' . $key];
                                                                }
                                                                if ($row->inline) {
                                                                    $class = 'form-check form-check-inline ';
                                                                    if ($row->required) {
                                                                        $attr['class'] = 'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label mb-0 ml-1';
                                                                } else {
                                                                    $class = 'form-check';
                                                                    if ($row->required) {
                                                                        $attr['class'] = 'form-check-input required';
                                                                    } else {
                                                                        $attr['class'] = 'form-check-input';
                                                                    }
                                                                    $l_class = 'form-check-label';
                                                                }
                                                            ?>
                                                            <div class=" <?php echo e($class); ?>">
                                                                <?php echo e(Form::radio($row->name, $options->value, isset($options->selected) && $options->selected ? true : false, $attr)); ?>

                                                                <label class="<?php echo e($l_class); ?>"
                                                                    for="<?php echo e($row->name . '_' . $key); ?>"><?php echo e($options->label); ?></label>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-radio "></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'select'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $attr = ['class' => 'form-select w-100', 'id' => 'sschoices-multiple-remove-button', 'data-trigger'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                            if (isset($row->multiple) && !empty($row->multiple)) {
                                                                $attr['multiple'] = 'true';
                                                                $attr['name'] = $row->name . '[]';
                                                            }
                                                            if (isset($row->className) && $row->className == 'calculate') {
                                                                $attr['class'] = $attr['class'] . ' ' . $row->className;
                                                            }
                                                            if ($row->label == 'Registration') {
                                                                $attr['class'] = $attr['class'] . ' registration';
                                                            }
                                                            if (isset($row->is_parent) && $row->is_parent == 'true') {
                                                                $attr['class'] = $attr['class'] . ' parent';
                                                                $attr['data-number-of-control'] = isset($row->number_of_control) ? $row->number_of_control : 1;
                                                            }
                                                            $values = [];
                                                            $selected = [];
                                                            foreach ($row->values as $options) {
                                                                $values[$options->value] = $options->label;
                                                                if (isset($options->selected) && $options->selected) {
                                                                    $selected[] = $options->value;
                                                                }
                                                            }
                                                        ?>
                                                        <?php if(isset($row->is_parent) && $row->is_parent == 'true'): ?>
                                                            <?php echo e(Form::label($row->name, $row->label)); ?><?php if($row->required): ?>
                                                                <span class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                            <div class="input-group">
                                                                <?php echo e(Form::select($row->name, $values, $selected, $attr)); ?>

                                                            </div>
                                                        <?php else: ?>
                                                            <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                            <?php if($row->required): ?>
                                                                <span class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                            <?php if(isset($row->description)): ?>
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="<?php echo e($row->description); ?>">?</span>
                                                            <?php endif; ?>
                                                            <?php echo e(Form::select($row->name, $values, $selected, $attr)); ?>

                                                        <?php endif; ?>
                                                        <?php if($row->label == 'Registration'): ?>
                                                            <span class="text-warning registration-message"></span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'autocomplete'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        
                                                        <?php
                                                            $attr = ['class' => 'form-select w-100', 'id' => 'sschoices-multiple-remove-button', 'data-trigger'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                            if (isset($row->multiple) && !empty($row->multiple)) {
                                                                $attr['multiple'] = 'true';
                                                                $attr['name'] = $row->name . '[]';
                                                            }
                                                            if (isset($row->className) && $row->className == 'calculate') {
                                                                $attr['class'] = $attr['class'] . ' ' . $row->className;
                                                            }
                                                            if ($row->label == 'Registration') {
                                                                $attr['class'] = $attr['class'] . ' registration';
                                                            }
                                                            if (isset($row->is_parent) && $row->is_parent == 'true') {
                                                                $attr['class'] = $attr['class'] . ' parent';
                                                                $attr['data-number-of-control'] = isset($row->number_of_control) ? $row->number_of_control : 1;
                                                            }
                                                            $values = [];
                                                            $selected = [];
                                                        ?>
                                                        <div class="form-group">
                                                            <label for="autocompleteInputZero"
                                                                class="form-label"><?php echo html_entity_decode($row->label); ?></label>
                                                            <input type="text" class="form-control"
                                                                placeholder="<?php echo e($row->label); ?>" list="list-timezone"
                                                                name="autocomplete" id="input-datalist">
                                                            <datalist id="list-timezone">
                                                                <?php $__currentLoopData = $row->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $options): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <?php if(is_object($options) && property_exists($options, 'value')): ?>
                                                                        <option value="<?php echo e($options->value); ?>">
                                                                        </option>
                                                                    <?php endif; ?>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </datalist>
                                                        </div>
                                                    </div>
                                                <?php elseif($row->type == 'date'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $attr = ['class' => 'form-control'];
                                                            $attr = ['id' => 'datefield'];
                                                            $attr = ['min' => '1900-01-01'];
                                                            $attr = ['max' => '2000-13-13'];
                                                            //$attr = ['onfocus' => 'this.max=new Date().toISOString().split("T")[0]'];
                                                            $attr = ['autocomplete' => 'off'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = 'datefield required';
                                                            }
                                                        ?>
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::date($row->name, isset($row->value) ? $row->value : null, $attr)); ?>

                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-date"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'hidden'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php echo e(Form::hidden($row->name, isset($row->value) ? $row->value : null)); ?>

                                                    </div>
                                                <?php elseif($row->type == 'number'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $row_class = isset($row->className) ? $row->className : '';
                                                            $attr = ['class' => 'number' . $row_class];
                                                            //$attr['pattern'] = '[0-9\s]{8,10}';
                                                            //$attr['onkeydown'] = 'return event.keyCode !== 69';
                                                            //$attr['id'] = 'numberfield';
                                                            if (isset($row->min)) {
                                                                $attr['min'] = $row->min;
                                                            }
                                                            if (isset($row->max)) {
                                                                $attr['max'] = $row->max;
                                                            }
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required ';
                                                            }
                                                        ?>
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::number($row->name, isset($row->value) ? $row->value : null, $attr)); ?>

                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-number"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'textarea'): ?>
                                                    <div class="form-group <?php echo e($col); ?> "
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $attr = ['class' => 'form-control text-area-height'];
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . ' required';
                                                            }
                                                            if (isset($row->rows)) {
                                                                $attr['rows'] = $row->rows;
                                                            } else {
                                                                $attr['rows'] = '3';
                                                            }
                                                            if (isset($row->placeholder)) {
                                                                $attr['placeholder'] = $row->placeholder;
                                                            }
                                                            if ($row->subtype == 'ckeditor') {
                                                                $attr['class'] = $attr['class'] . ' ck_editor';
                                                            }
                                                        ?>
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::textarea($row->name, isset($row->value) ? $row->value : null, $attr)); ?>

                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-textarea"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'button'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php if(isset($row->value) && !empty($row->value)): ?>
                                                            <a href="<?php echo e($row->value); ?>" target="_new"
                                                                class="<?php echo e($row->className); ?>"><?php echo e(__($row->label)); ?></a>
                                                        <?php else: ?>
                                                            <?php echo e(Form::button(__($row->label), ['name' => $row->name, 'type' => $row->subtype, 'class' => $row->className, 'id' => $row->name])); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'text'): ?>
                                                    <?php
                                                        $class = '';
                                                        if ($row->subtype == 'text' || $row->subtype == 'email') {
                                                            $class = 'form-group-text';
                                                        }
                                                    ?>
                                                    <div class="form-group <?php echo e($class); ?> <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $attr = ['class' => 'form-control ' . $row->subtype];
                                                       
                                                            /*$attr['oninput'] = 'this.value = this.value.replace(/[0-9]/g,"")';*/
                                                            if ($row->required) {
                                                                $attr['required'] = 'required';
                                                                $attr['class'] = $attr['class'] . 'datetimefield required';
                                                            }
                                                            if (isset($row->maxlength)) {
                                                                $attr['max'] = $row->maxlength;
                                                            }
                                                            if (isset($row->placeholder)) {
                                                                $attr['placeholder'] = $row->placeholder;
                                                            }
                                                            $value = isset($row->value) ? $row->value : '';
                                                            if ($row->subtype == 'datetime-local') {
                                                                $row->subtype = 'datetime-local';
                                                                //$attr['class'] = $attr['class'] . 'datetimefield date_time';
                                                                $attr = ['class' => 'datetimefield date_time'];
                                                                $attr = ['id' => 'datetimefield'];                                                                
                                                                $attr = ['min' => '1900-01-01'];
                                                                $attr = ['max' => '2000-01-01'];
                                                            }
                                                        ?>
                                                        <label for="<?php echo e($row->name); ?>"
                                                            class="form-label"><?php echo html_entity_decode($row->label); ?>

                                                            <?php if($row->required): ?>
                                                                <span class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                        </label>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <?php echo e(Form::input($row->subtype, $row->name, $value, array_merge($attr, ['data-input' => $row->name]))); ?>

                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-text"></div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'starRating'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php
                                                            $value = isset($row->value) ? $row->value : 0;
                                                            $num_of_star = isset($row->number_of_star) ? $row->number_of_star : 5;
                                                        ?>
                                                        <?php echo e(Form::label($row->name, $row->label, ['class' => 'form-label'])); ?>

                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <?php if(isset($row->description)): ?>
                                                            <span type="button" class="tooltip-element"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="<?php echo e($row->description); ?>">
                                                                ?
                                                            </span>
                                                        <?php endif; ?>
                                                        <div id="<?php echo e($row->name); ?>" class="starRating"
                                                            data-value="<?php echo e($value); ?>"
                                                            data-num_of_star="<?php echo e($num_of_star); ?>">
                                                        </div>
                                                        <input type="hidden" name="<?php echo e($row->name); ?>"
                                                            value="<?php echo e($value); ?>" class="calculate"
                                                            data-star="<?php echo e($num_of_star); ?>">
                                                    </div>
                                                <?php elseif($row->type == 'SignaturePad'): ?>
                                                    <?php
                                                        $attr = ['class' => $row->name];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : null;
                                                    ?>
                                                    <div class="row form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php echo $__env->make('form.js.signature', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <div class="col-12">
                                                            <label for="<?php echo e($row->name); ?>"
                                                                class="form-label"><?php echo e($row->label); ?></label>
                                                            <?php if($row->required): ?>
                                                                <span class="text-danger align-items-center">*</span>
                                                            <?php endif; ?>
                                                            <?php if(isset($row->description)): ?>
                                                                <span type="button" class="tooltip-element"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="<?php echo e($row->description); ?>">
                                                                    ?
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <div class="signature-pad-body">
                                                                <canvas class="signaturePad form-control"
                                                                    id="<?php echo e($row->name); ?>"></canvas>
                                                                <div class="sign-error"></div>
                                                                <?php echo Form::hidden($row->name, $value, $attr); ?>

                                                                <div class="buttons signature_buttons">
                                                                    <button id="save<?php echo e($row->name); ?>"
                                                                        type="button" data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom"
                                                                        data-bs-original-title="<?php echo e(__('Guardar')); ?>"
                                                                        class="btn btn-primary btn-sm"><?php echo e(__('Guardar')); ?></button>
                                                                    <button id="clear<?php echo e($row->name); ?>"
                                                                        type="button" data-bs-toggle="tooltip"
                                                                        data-bs-placement="bottom"
                                                                        data-bs-original-title="<?php echo e(__('Limpiar')); ?>"
                                                                        class="btn btn-danger btn-sm"><?php echo e(__('Limpiar')); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if(@$row->value != ''): ?>
                                                            <div class="col-lg-6 col-md-12 col-12">
                                                                <img src="<?php echo e(Storage::url($row->value)); ?>"
                                                                    width="80%" class="border" alt="">
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php elseif($row->type == 'break'): ?>
                                                    <hr class="hr_border">
                                                <?php elseif($row->type == 'location'): ?>
                                                    <div class="form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php echo $__env->make('form.js.map', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <input id="pac-input" class="controls" type="text"
                                                            name="location" placeholder="Búsqueda" />
                                                        <div id="map"></div>
                                                    </div>
                                                <?php elseif($row->type == 'video'): ?>
                                                    <?php
                                                        $attr = ['class' => $row->name];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : null;
                                                    ?>
                                                    <div class="row form-group <?php echo e($col); ?>"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php echo $__env->make('form.js.video', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <label for="<?php echo e($row->name); ?>"
                                                            class="form-label"><?php echo html_entity_decode($row->label); ?></label>
                                                        <?php if($row->required): ?>
                                                            <span class="text-danger align-items-center">*</span>
                                                        <?php endif; ?>
                                                        <div class="d-flex justify-content-start">
                                                            <button type="button" class="btn btn-primary"
                                                                id="videostream">
                                                                <span class="svg-icon svg-icon-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="24" height="24"
                                                                        viewBox="0 0 24 24">
                                                                        <path
                                                                            d="M5 5h-3v-1h3v1zm8 5c-1.654 0-3 1.346-3 3s1.346 3 3 3 3-1.346 3-3-1.346-3-3-3zm11-4v15h-24v-15h5.93c.669 0 1.293-.334 1.664-.891l1.406-2.109h8l1.406 2.109c.371.557.995.891 1.664.891h3.93zm-19 4c0-.552-.447-1-1-1-.553 0-1 .448-1 1s.447 1 1 1c.553 0 1-.448 1-1zm13 3c0-2.761-2.239-5-5-5s-5 2.239-5 5 2.239 5 5 5 5-2.239 5-5z"
                                                                            fill="black" />
                                                                    </svg>
                                                                </span>
                                                                <?php echo e(__('Grabar video')); ?>

                                                            </button>
                                                        </div>
                                                        <?php if($row->required): ?>
                                                            <div class="error-message required-text"></div>
                                                        <?php endif; ?>
                                                        <div class="cam-buttons d-none">
                                                            <video autoplay controls id="web-cam-container"
                                                                class="p-2" style="width:100%; height:80%;">
                                                                <?php echo e(__("Your browser doesn't support the video tag")); ?>

                                                            </video>
                                                            <div class="py-4">
                                                                <div class="field-required">
                                                                    <div class="mb-2 btn btn-lg btn-primary float-end">
                                                                        <div id="timer">
                                                                            <span id="hours">00:</span>
                                                                            <span id="mins">00:</span>
                                                                            <span id="seconds">00</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div id='gUMArea' class="video_cam">
                                                                    <div class="web_cam_video">
                                                                        <input type="hidden"
                                                                            class="<?php echo e(implode(' ', $attr)); ?>"
                                                                            name="media" checked
                                                                            value="<?php echo e($value); ?>"
                                                                            id="mediaVideo">

                                                                    </div>
                                                                </div>
                                                                <div id='btns'>
                                                                    <div id="controls">
                                                                        <button class="btn btn-light-primary"
                                                                            id='start' type="button">
                                                                            <span class="svg-icon svg-icon-2">
                                                                                <span class="svg-icon svg-icon-2">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24" height="24"
                                                                                        viewBox="0 0 24 24">
                                                                                        <path
                                                                                            d="M16 18c0 1.104-.896 2-2 2h-12c-1.105 0-2-.896-2-2v-12c0-1.104.895-2 2-2h12c1.104 0 2 .896 2 2v12zm8-14l-6 6.223v3.554l6 6.223v-16z"
                                                                                            fill="black" />
                                                                                    </svg>
                                                                                </span>
                                                                            </span>
                                                                            <?php echo e(__('Empezar')); ?>

                                                                        </button>
                                                                        <button class="btn btn-light-danger"
                                                                            id='stop' type="button">
                                                                            <span class="svg-icon svg-icon-2">
                                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                                    width="24" height="24"
                                                                                    viewBox="0 0 24 24">
                                                                                    <path d="M2 2h20v20h-20z"
                                                                                        fill="black" />
                                                                                </svg>
                                                                            </span>
                                                                            <span
                                                                                class="indicator-label"><?php echo e(__('Detener')); ?></span>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php elseif($row->type == 'selfie'): ?>
                                                    <?php
                                                        $attr = ['class' => $row->name];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        $value = isset($row->value) ? $row->value : null;
                                                    ?>
                                                    <div class="row <?php echo e($col); ?> selfie_screen"
                                                        data-name=<?php echo e($row->name); ?>>
                                                        <?php echo $__env->make('form.js.selfie', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                        <div class="col-md-6 selfie_photo">
                                                            <div class="form-group">
                                                                <label for="<?php echo e($row->name); ?>"
                                                                    class="form-label"><?php echo e($row->label); ?></label>
                                                                <?php if($row->required): ?>
                                                                    <span
                                                                        class="text-danger align-items-center">*</span>
                                                                <?php endif; ?>
                                                                <div id="my_camera" class="camera_screen"></div>
                                                                <br />
                                                                <button type="button"
                                                                    class="btn btn-default btn-light-primary"
                                                                    onClick="take_snapshot()">
                                                                    <i class="ti ti-camera"></i>
                                                                    <?php echo e(__('Tomar Selfie')); ?>

                                                                </button>
                                                                <input type="hidden" name="image"
                                                                    value="<?php echo e($value); ?>"
                                                                    class="image-tag  <?php echo e(implode(' ', $attr)); ?>">
                                                            </div>

                                                        </div>
                                                        <div class="mt-4 col-md-6">
                                                            <div id="results" class="selfie_result">
                                                                <?php echo e(__('Su imagen capturada aparecerá aquí...')); ?>

                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col cap">
                                    <?php if(UtilityFacades::getsettings('captcha_enable') == 'on'): ?>
                                        <?php if(UtilityFacades::getsettings('captcha') == 'hcaptcha'): ?>
                                            <?php echo HCaptcha::renderJs(); ?>

                                            <small
                                                class="text-danger font-weight-bold"><?php echo e(__('Nota: - Se requiere reCAPTCHA')); ?></small>
                                            <div class="g-hcaptcha"
                                                data-sitekey="<?php echo e(UtilityFacades::getsettings('hcaptcha_key')); ?>">
                                            </div>
                                            <?php echo HCaptcha::display(); ?>

                                            <?php $__errorArgs = ['g-hcaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="text-danger text-bold"><?php echo e($message); ?></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        <?php endif; ?>
                                        <?php if(UtilityFacades::getsettings('captcha') == 'recaptcha'): ?>
                                            <?php echo NoCaptcha::renderJs(); ?>

                                            <small
                                                class="text-danger font-weight-bold"><?php echo e(__('Nota: - Se requiere reCAPTCHA')); ?></small>
                                            <div class="g-recaptcha"
                                                data-sitekey="<?php echo e(UtilityFacades::getsettings('recaptcha_key')); ?>">
                                            </div>
                                            <?php echo NoCaptcha::display(); ?>

                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <div class="pb-0 mt-3 form-actions">
                                        <input type="hidden" name="form_value_id"
                                            value="<?php echo e(isset($form_value) ? $form_value->id : ''); ?>"
                                            id="form_value_id">
                                    </div>
                                </div>
                                <div id="errorMessage" class="error-message" style="display: none;">Requisitos de contraseña: al menos una letra, una mayúscula, un número, un carácter especial y tener al menos 12 caracteres</div>

                            </div>

                            <?php if(\Auth::guard('api')->user()->rol = 'Administrador' || 'Usuario Operador 1'): ?>
                            <a href="/forms/survey/RomQjOy5eV75aEP4V27q" class="btn btn-primary" id="add-new-dea" target="_blank" style="display:none;">Agregar un nuevo DEA <span>(Al hacer clic se abrirá una nueva pestaña)</span></a>
                            <?php endif; ?>

                            <hr>
                            <div class="over-auto">
                                <div class="float-right"> 
                                    <?php echo Form::button(__('Anterior'), ['class' => 'btn btn-default', 'id' => 'prevBtn', 'onclick' => 'nextPrev(-1)']); ?>

                                    <?php echo Form::button(__('Siguiente'), ['class' => 'btn btn-primary', 'id' => 'nextBtn', 'onclick' => 'nextPrev(1)']); ?>

                                </div>
                            </div>
                            <div class="extra_style" style="display:none">
                                <?php if(isset($array)): ?>
                                    <?php $__currentLoopData = $array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="step"></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                          <div id="passvalid" style="display:none;">Requisitos de contraseña: al menos una letra minúscula, una letra mayúscula, un número y tener al menos 12 caracteres. Evite utilizar símbolos en su contraseña.</div>
                        </form>
                        
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if($form->allow_share_section == 1): ?>
        <div class="row">
            <?php echo $__env->make('form.js.share-section', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="mx-auto col-xl-7 order-xl-1">
                <div class="card">
                    <div class="card-header">
                        <h5> <i class="me-2" data-feather="share-2"></i><?php echo e(__('Share')); ?></h5>
                    </div>
                    <div class="card-body ">
                        <div class="m-auto form-group col-6">
                            <p><?php echo e(__('Utilice este enlace para compartir la encuesta con sus participantes.')); ?></p>
                            <div class="input-group">
                                <input type="text" value="<?php echo e(route('forms.survey', $id)); ?>"
                                    class="form-control js-content" id="pc-clipboard-1"
                                    placeholder="Type some value to copy">
                                <a href="#" class="btn btn-primary js-copy" data-clipboard="true"
                                    data-clipboard-target="#pc-clipboard-1"> <?php echo e(__('Copiar')); ?>

                                </a>
                            </div>
                            <div class="mt-3 social-links-share">
                                <a href="https://api.whatsapp.com/send?text=<?php echo e(route('forms.survey', $id)); ?>"
                                    title="Whatsapp" class="social-links-share-main">
                                    <i class="ti ti-brand-whatsapp"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=<?php echo e(route('forms.survey', $id)); ?>"
                                    title="Twitter" class="social-links-share-main">
                                    <i class="ti ti-brand-twitter"></i>
                                </a>
                                <a href="https://www.facebook.com/share.php?u=<?php echo e(route('forms.survey', $id)); ?>"
                                    title="Facebook" class="social-links-share-main">
                                    <i class="ti ti-brand-facebook"></i>
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo e(route('forms.survey', $id)); ?>"
                                    title="Linkedin" class="social-links-share-main">
                                    <i class="ti ti-brand-linkedin"></i>
                                </a>
                                <a href="javascript:void(1);" class="social-links-share-main" title="Ver código QR"
                                    data-action="<?php echo e(route('forms.survey.qr', $id)); ?>" id="share-qr-image">
                                    <i class="ti ti-qrcode"></i>
                                </a>
                                <a href="javascript:void(0)" title="Embed" class="social-links-share-main"
                                    onclick="copyToClipboard('#embed-form-<?php echo e($form->id); ?>')"
                                    id="embed-form-<?php echo e($form->id); ?>"
                                    data-url='<iframe src="<?php echo e(route('forms.survey', $id)); ?>" scrolling="auto" align="bottom" style="height:100vh;" width="100%"></iframe>'>
                                    <i class="ti ti-code"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if($form->allow_comments == 1): ?>
        <div class="row">
            <div class="mx-auto col-xl-7 order-xl-1">
                <div class="card" id="card-holder">
                    <div class="card-header">
                        <h5> <i class="me-2" data-feather="message-circle"></i><?php echo e(__('Comentarios')); ?></h5>
                    </div>
                    <?php echo Form::open([
                        'route' => 'form.comment.store',
                        'method' => 'Post',
                    ]); ?>

                    <div class="card-body">
                        <div class="form-group">
                            <?php echo Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Ingrese su nombre')]); ?>

                        </div>
                        <div class="form-group">
                            <?php echo Form::textarea('comment', null, [
                                'class' => 'form-control',
                                'rows' => '3',
                                'required',
                                'placeholder' => __('Agregar comentario'),
                            ]); ?>

                        </div>
                    </div>
                    <input type="hidden" id="form_id" name="form_id" value="<?php echo e($form->id); ?>">
                    <div class="card-footer">
                        <div class="text-end">
                            <?php echo Form::submit(__('Agregar comentario'), ['class' => 'btn btn-primary']); ?>

                        </div>
                        <?php echo Form::close(); ?>

                        <?php $__currentLoopData = $form->commmant; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="comments-item">
                                <div class="comment-user-icon">
                                    <img src="<?php echo e(asset('assets/images/comment.png')); ?>">
                                </div>
                                <span class="text-left comment-info">
                                    <h6><?php echo e($value->name); ?></h6>
                                    <span class="d-block"><small><?php echo e($value->comment); ?></small></span>
                                    <h6 class="d-block">
                                        <small>(<?php echo e($value->created_at->diffForHumans()); ?>)</small>
                                        <a href="#reply-comment" class="text-dark reply-comment-<?php echo e($value->id); ?>"
                                            id="comment-reply" data-bs-toggle="collapse"
                                            data-id="<?php echo e($value->id); ?>" title="<?php echo e(__('Responder')); ?>">
                                            <?php echo e(__('Responder')); ?></i></a>
                                        <?php if(Auth::user()): ?>
                                            <?php echo Form::open([
                                                'method' => 'DELETE',
                                                'route' => ['form.comment.destroy', $value->id],
                                                'id' => 'delete-form-' . $value->id,
                                                'class' => 'd-inline',
                                            ]); ?>

                                            <a href="#" class="text-dark show_confirm" title="Eliminar"
                                                id="delete-form-<?php echo e($value->id); ?>"><?php echo e(__('Eliminar')); ?></a>
                                            <?php echo Form::close(); ?>

                                        <?php endif; ?>
                                    </h6>
                                    <li class="list-inline-item"> </li>
                                    <?php $__currentLoopData = $value->replyby; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="comment-replies">
                                            <div class="comment-user-icon">
                                                <img src="<?php echo e(asset('assets/images/comment.png')); ?>">
                                            </div>
                                            <div class="comment-replies-content">
                                                <h6><?php echo e($reply_value->name); ?></h6>
                                                <span class="d-block"><small><?php echo e($reply_value->reply); ?></small></span>
                                                <h6 class="d-block">
                                                    <small>(<?php echo e($reply_value->created_at->diffForHumans()); ?>)</small>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </span>
                            </div>
                            <?php echo Form::open([
                                'route' => 'form.comment.reply.store',
                                'method' => 'Post',
                                'data-validate',
                            ]); ?>

                            <div class="row commant" id="reply-comment-<?php echo e($value->id); ?>">
                                <div class="form-group">
                                    <?php echo Form::text('name', null, ['class' => 'form-control', 'required', 'placeholder' => __('Ingrese su nombre')]); ?>

                                </div>
                                <div class="form-group">
                                    <?php echo Form::textarea('reply', null, [
                                        'class' => 'form-control',
                                        'rows' => '2',
                                        'required',
                                        'placeholder' => __('Agregar comentario'),
                                    ]); ?>

                                </div>
                                <input type="hidden" id="form_id" name="form_id" value="<?php echo e($form->id); ?>">
                                <input type="hidden" id="comment_id" name="comment_id"
                                    value="<?php echo e($value->id); ?>">
                                <div class="card-footer">
                                    <div class="text-end">
                                        <?php echo Form::submit(__('Agregar comentario'), ['class' => 'btn btn-primary']); ?>

                                    </div>
                                </div>
                            </div>
                            <?php echo Form::close(); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<div class="forms-footer">
    <div class="footer-bottom footer-mobile">
        <div class="footer_gov_">
           <div class="centradototal_ fooflex">
              <div class="logos_footer_gov"><a href="https://www.colombia.co" target="_blank"><img class="marcaco_l" src="../../images/logo.png" alt="colombia.co"></a></div>
              <div class="alcaldia_mod_footer"><a href="https://www.medellin.gov.co/es"><img  class="log_nww_footer" src="../../images/logo_nav_footer.png" alt="Alcaldía de Medellín"></a></div>
           </div>
        </div>
     </div>
</div>

<!--MODALS TEXTS-->
<!--Inicio Modal 2 -->
<div id="custom-modal" class="custom-modal">
    <div class="custom-modal-dialog" id="anexo2">
        <div class="custom-modal-content">
           <span class="close-modal">Cerrar</span>
            <div class="custom-modal-body">
                <div class="custom-modal-inner">
                     
                    <h6 class="modal-title" id="exampleModalLongTitle">INSTRUCCIONES PARA DILIGENCIAR EL ANEXO TÉCNICO No. 2</h6>

                    <p><b>Responsable del lugar con alta afluencia del p&uacute;blico</b></p>
                    
                    <p>1. Nombre completo: Escriba el nombre completo del responsable del lugar con alta afluencia del p&uacute;blico que registra el/los DEA.</p>
                    
                    <p>2. Documento de identificaci&oacute;n: Escriba el n&uacute;mero del documento de identificaci&oacute;n del responsable del lugar con alta afluencia del p&uacute;blico que registra el/los DEA.</p>
                    
                    <p><b>Datos del lugar con alta afluencia del p&uacute;blico.</b></p>
                    
                    <p>3. Nombre: Escriba el nombre del lugar con alta afluencia de p&uacute;blico que registra la instalaci&oacute;n de el/los DEA .</p>
                    
                    <p>4. Direcci&oacute;n: Escriba la direcci&oacute;n completa del lugar con alta afluencia de p&uacute;blico que registra la instalaci&oacute;n de(l)/los DEA.</p>
                    
                    <p>5. C&oacute;digo postal: Escriba el c&oacute;digo postal del Iugar con alta afluencia de p&uacute;blico que registra la instalaci&oacute;n de(l)/los DEA.</p>
                    
                    <p>6. Ciudad o municipio: Escriba el municipio donde est&aacute; ubicado el lugar con alta afluencia de p&uacute;blico que registra la instalaci&oacute;n de(l)/los DEA.</p>
                    
                    <p>7. Departamento: Escriba el departamento donde est&aacute; ubicado el lugar con alta afluencia de p&uacute;blico que registra la instalaci&oacute;n de(l)/los DEA.</p>
                   
                    <p><b>Declaraci&oacute;n</b></p>
                    
                    <p>8. Se&ntilde;ale con una (X) la opci&oacute;n que corresponda:</p>
                    
                    <p>a. Instalaci&oacute;n: se trata de la instalaci&oacute;n permanente o es temporal de(l)/los DEA. </p>
                    <p> b. Cambio de titular: esta declaración, se trata de un cambio del titular de(l)/los DEA.</p>
                    <p>c. Retirada: esta declaración, se trata de la retirada de(l)/los DEA.</p>
                    <p>d. Modificación de la ubicación: esta declaración, se trata de la modificación de la ubicación de(l)/los DEA.</p>
                    <p>e. Otros; señale si esta declaración se trata de otro tipo.</p>
                    
                    <p><b>Tipo de instalaci&oacute;n</b></p>
                    
                    <p>9. Se&ntilde;ale con una (X) la opci&oacute;n que corresponda:</p>
                    
                    <p>a. Obligatoria: si la instalaci&oacute;n de(l)/los DEA es obligatoria. </p>
                  
                    <p>b. Voluntaria: si la instalaci&oacute;n de(l)/los DEA corresponde a espacios no obligados a la dotaci&oacute;n de estos.</p>
                    
                    <p><b> Tipo de espacio o lugar de alta afluencia de p&uacute;blico</b></p>
                    
                    <p>10. Tipo de espacio: De conformidad con el presente acto administrativo indique el tipo de espacio o lugar con alta afluencia de personas.</p>
                  
                    <p><b>Desfibriladores Externos Automáticos (Estos datos se deben diligenciar por cada uno de los DEA que registra)</b></p>
                  
                    <p>11. Fecha: día, mes, año de instalación y puesta en funcionamiento del DEA.</p>
                    <p>12. No. de serie: Escriba el número de serie del DEA.</p>
                    <p>13. Modelo: Escriba el modelo del DEA.</p>
                     <p>14. Marca: Escriba la marca del DEA.</p>
                     <p>15. Distribuidor autorizado o fabricante: Escriba el distribuidor o fabricante del DEA.</p>
                     <p>16. Descripción del lugar donde está ubicado: Escriba el nombre del sitio donde está ubicado el DEA.</p>
                     <p>17. Coordenadas de geolocalización: Escriba las coordenadas de geolocalización (GPS) del espacio o sitio donde están ubicados los DEA. Opcional.</p>
                    
                    <p><b>Personal certificado en el uso del DEA.</b> Se debe diligenciar por cada una de las personas capacitadas y certificadas en DEA.</p>
                    
                      <p> 18. Documento de identidad: Escriba el número del documento de identidad de la persona que cuenta con el entrenamiento y está certificado para la utilización del DEA.</p>
                      <p>19. Nombres y apellidos: Escriba los nombres y apellidos completos de la persona que cuenta con el entrenamiento y está certificado para la utilización de(l)/los DEA.</p>
                      <p>20. Entidad que certifica la capacitación en DEA. Escriba el nombre de la entidad que certifica la capacitación en DEA.</p>
                      <p>21. Fecha de certificación: Escriba la fecha de certificación de la última capacitación en DEA.</p>
                      <p>22. Señale con una (X) en todos y cada uno de los siguientes ítems, la declaratoria de(l)/los DEA.</p>
                    
                      <p><b>Respecto al personal:</b></p>
                    
                      <p>23. Señale con una (X) en todos y cada uno de los siguientes ítems, la declaratoria respecto al personal entrenado y certificado en DEA.</p>
                    
                      <p> a. El personal encargado del manejo del DEA dispone de entrenamiento y actualización de los conocimientos exigidos; y, </p>
                          <p>b. Durante el horario de actividad se cuenta con un número plural de personas entrenadas para su uso.</p>
                    
                      <p><b>Firmas:</b></p>
                    
                      <p>24. Municipio: Escriba el nombre del municipio donde está ubicado el lugar con alta afluencia de público que hace la declaración de(l)/los DEA;</p>
                      <p>25. Fecha: día, mes, año en que se llevó a cabo la declaratoria de(l)/los DEA; y</p>
                      <p>26. Firma del responsable del lugar con alta afluencia de público que hace la declaratoria de(l)/los DEA.</p>

                </div>
            </div>
        </div>
    </div>
</div>
<!--Fin modal 2-->
<!-- Inicio Modal 3 -->
<div id="custom-modal" class="custom-modal2">
    <div class="custom-modal-dialog" id="anexo3">
        <div class="custom-modal-content">
           <span class="close-modal">Cerrar</span>
            <div class="custom-modal-body">
                <div class="custom-modal-inner">
                    <h6 class="modal-title" id="exampleModalLongTitle">INSTRUCCIONES PARA DILIGENCIAR EL ANEXO TÉCNICO No. 3</h6>
                    
                    <p>1. Fecha del evento: Escriba la fecha en la cual sucedi&oacute; el evento donde se utiliz&oacute; el DEA.</p>
                    
                    <p>2. Nombre del lugar del evento: Escriba el nombre del lugar con alta afluencia de p&uacute;blico donde sucedi&oacute; el evento.</p>
                    
                    <p>Datos de la persona atendida en el evento</p>
                    
                    <p>3. Nombre completo: Escriba el nombre completo de la persona atendida con el uso del DEA;</p>
                    
                    <p>4. Tipo de documento de identificaci&oacute;n: Escriba el tipo de documento de identificaci&oacute;n de la persona atendida con el uso del DEA;</p>
                    
                    <p>5. N&uacute;mero de documento de identificaci&oacute;n: Escriba el n&uacute;mero de documento de identificaci&oacute;n de la persona atendida con el uso del DEA;</p>
                    
                    <p>6. Edad: Escriba la edad en a&ntilde;os de la persona atendida con el uso del DEA;</p>
                    
                    <p>7. Sexo: Marque con una X el sexo de la persona atendida con el uso del DEA;</p>
                    
                    <p>8. Asegurador en Salud: Escriba el nombre de la aseguradora en salud a la cual se encuentra afiliada la persona atendida con el uso del DEA (entidades promotoras de salud, las entidades que administren planes voluntarios de salud, las entidades adaptadas de salud, las administradoras de riesgos profesionales en sus actividades de salud).</p>
                    
                    <p><b>Datos del evento en donde se utiliz&oacute; el Desfibrilador Externo Autom&aacute;tico - DEA</b></p>
                    
                    <p>9. Nombre de la persona que utiliz&oacute; el DEA: Escriba el nombre completo de la persona que utiliz&oacute; el DEA para realizar la descarga; Tipo de documento de identificaci&oacute;n: Escriba el n&uacute;mero del documento de identificaci&oacute;n de la persona que utiliz&oacute; el DEA para realizar la descarga; N&uacute;mero de documento de identificaci&oacute;n: Escriba el n&uacute;mero de documento de identificaci&oacute;n de la persona que utiliz&oacute; el DEA para realizar la descarga; Hora de inicio del evento: Escriba en n&uacute;meros la hora en la cual se inici&oacute; el eento en el cual se utiliz&oacute; el DEA; Hora de activaci&oacute;n de la cadena de supervivencia: Escriba en n&uacute;meros la hora en la cual se activ&oacute; la cadena de supervivencia del evento en el cual se utiliz&oacute; el DEA; Hora de utilizaci&oacute;n del DEA: Escriba en n&uacute;meros la hora en la cual se utiliz&oacute; el DEA; y Hora de traslado de la persona atendida a la instituci&oacute;n de salud: Escriba en n&uacute;meros la hora a la cual se realiz&oacute; el traslado de la persona atendida a la instituci&oacute;n de salud. En caso de fallecimiento de la persona en el lugar del evento, escriba N/A.</p>
                    
                    <p>10. Tipo de documento de identificación: Escriba el número del documento de identificación de la persona que utilizó el DEA para realizar la descarga;</p>
                     <p>11. Número de documento de identificación: Escriba el número de documento de identificación de la persona que utilizó el DEA para realizar la descarga;</p>
                     <p>12. Hora de inicio del evento: Escriba en números la hora en la cual se inició el eento en el cual se utilizó el DEA;</p>
                     <p> 13. Hora de activación de la cadena de supervivencia: Escriba en números la hora en la cual se activó la cadena de supervivencia del evento en el cual se utilizó el DEA;</p>
                     <p>14. Hora de utilización del DEA: Escriba en números la hora en la cual se utilizó el DEA; y</p>
                     <p>15. Hora de traslado de la persona atendida a la institución de salud: Escriba en números la hora a la cual se realizó el traslado de la persona atendida a la institución de salud. En caso de fallecimiento de la persona en el lugar del evento, escriba N/A.</p>
                   
                    <p><b>Datos del medio de transporte en el cual es trasladada la persona atendida a la instituci&oacute;n de salud</b></p>
                    
                    <p>En caso de fallecimiento de la persona en el lugar del evento, no debe diligenciar las variables 17, 18 y 19.</p>
                    
                    <p>16. Nombre de la persona encargada del traslado: Escriba el nombre completo de la persona responsable de realizar el traslado a la instituci&oacute;n de salud establecida en la ruta; Medio de transporte utilizado para el traslado: Marque con una (X) el medio de transporte en el que se realiz&oacute; el traslado a la instituci&oacute;n de salud establecida en la ruta. Si la opci&oacute;n seleccionada es &ldquo;Otro&rdquo;, debe escribir cu&aacute;l fue el medio de transporte utilizado; Nombre de la empresa de la ambulancia: escriba el nombre de la empresa a la cual pertenece la ambulancia que realiz&oacute; el traslado; y. Observaciones: Escriba las observaciones que estime pertinentes, diferentes a los datos reportados en las variables anteriores.</p>
                          
                    <p>17. Medio de transporte utilizado para el traslado: Marque con una (X) el medio de transporte en el que se realizó el traslado a la institución de salud establecida en la ruta. Si la opción seleccionada es “Otro”, debe escribir cuál fue el medio de transporte utilizado;</p>
                    <p>18. Nombre de la empresa de la ambulancia: escriba el nombre de la empresa a la cual pertenece la ambulancia que realizó el traslado; y.</p>
                    <p>19. Observaciones: Escriba las observaciones que estime pertinentes, diferentes a los datos reportados en las variables anteriores.</p>

                </div>
            </div>
        </div>
    </div>
</div>
<!--Fin modal 3-->
<!-- END MODALS-->

<?php if($form->conditional_rule == '1'): ?>
    <?php echo $__env->make('form.js.conditional-rule', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/choices.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/clipboard.min.js')); ?>"></script>
    <script>
        new ClipboardJS('[data-clipboard=true]').on('success', function(e) {
            e.clearSelection();
        });
    </script>
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).attr('data-url')).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('¡Excelente!', '<?php echo e(__('Copy Link Successfully..')); ?>', 'success',
                '<?php echo e(asset('assets/images/notification/ok-48.png')); ?>', 4000);
        }

        $(document).ready(function() {
            let area = document.createElement('textarea');
            document.body.appendChild(area);
            area.style.display = "none";
            let content = document.querySelectorAll('.js-content');
            let copy = document.querySelectorAll('.js-copy');
            for (let i = 0; i < copy.length; i++) {
                copy[i].addEventListener('click', function() {
                    area.style.display = "block";
                    area.value = content[i].innerText;
                    area.select();
                    document.execCommand('copy');
                    area.style.display = "none";
                    this.innerHTML = 'Copiado ';
                    setTimeout(() => this.innerHTML = "Copiar", 2000);
                });
            }
        });
    </script>

<!--Para mostrar boton que permite hacer mas DEA's
<script>
$('#number-1703804402355-0').bind('keyup change', function(){
    var show = true;
    // Check each child input for data.
        if($(this).val().length==0){
            show = false;
        };
    // Hide or show the necessary elements based on the [show] flag.
    if(show){
        $('#add-new-dea').show();
    } else {
        $('#add-new-dea').hide();
    }
});
</script>-->

<!--Para mostrar modal de Anexo 2-->
<script>
    if (window.location.href == 'http://3.14.220.114:8000/forms/survey/m8VvJ4opengDa7Az1XPY' && 'http://3.14.220.114:8000/forms/survey/3KWYxk8mepkrdMyJNjQ9'){
        $('#showanextec2').show();
    }else{
        $('#showanextec2').hide();
        $('#showanextec3').hide();
        $('#anexo3').hide();
    }
</script>
<!--Para mostrar modal de Anexo 3
    <script>
if (window.location.href == 'http://3.14.220.114:8000/forms/survey/mJqAMrlNbWQWeyg5Kx2n') {
    $('#showanextec3').show();
}else {
            $('#showanextec3').hide();
        }
    </script>
-->
<!-- Validar campos de numero -->
<script>
    $(function () {
        $("input[class='number']").on('input', function (e) {
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
    });
    function onlynum() {
        let fm = document.getElementsByClassName("number");
        let res = ip.value;
    }
</script>

<!--Validar campos de fecha-->

<script>
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
 if(dd<10){
        dd='0'+dd
    } 
    if(mm<10){
        mm='0'+mm
    } 

today = yyyy+'-'+mm+'-'+dd;
document.getElementsByClassName("datefield required")[0].setAttribute("max", today);
</script>

<!-- PERMITIR SOLO TEXTO EN ESTOS CAMPOS-->
<script>
const selectElement = document.querySelector('input[name="namefield"]');
selectElement.addEventListener('input', (event) => {
  const result = document.querySelector('.result');
  event.target.value = event.target.value.replace(/[0-9`'"()/~&$*%*]/g, '');
  result.textContent = event.target.value;
});

const selectElement2 = document.querySelector('input[name="namefield2"]');
selectElement2.addEventListener('input', (event) => {
  const result2 = document.querySelector('.result2');
  event.target.value = event.target.value.replace(/[0-9`'"()/~&$*%+]/g, '');
  result2.textContent = event.target.value;
});

</script>

 <!--PARA VALIDAR CANTIDAD DE CARACTERES EN CEDULAS Y CODIGOS POSTALES -->
<script>
 document.querySelector('input[name="postalcode"]').oninput = function () {
    if (this.value.length > 6 ) {
        this.value = this.value.slice(0,6); 
    }else{
        alert="Ingrese 6 dígitos en el código postal"
    }
 }
 $("#postalcode").attr("maxlength", "6");
 $("#postalcode").attr("minlength", "6");
 $("#postalcode").attr("pattern", "(.){6,6}");
</script>
<script>
 document.querySelector('input[name="cedulacode"]').oninput = function () {
    if (this.value.length > 10) {
        this.value = this.value.slice(0,10); 
    }else{
        alert="Ingrese entre 8 y 10 dígitos en su número de identificación"
    }
 }
 $("#cedulacode").attr("maxlength", "10");
 $("#cedulacode").attr("minlength", "8");
 $("#cedulacode").attr("pattern", "(.){8,10}");
 $("#cedulacode").attr("pattern=/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9][A-Za-z0-9][A-Za-z0-9][A-Za-z0-9][A-Za-z0-9][A-Za-z0-9][A-Za-z0-9][A-Za-z0-9])$/");
</script>
<script>
    document.querySelector('input[name="cedulacodedea"]').oninput = function () {
        if (this.value.length > 10) {
        this.value = this.value.slice(0,10); 
    }else{
        alert="Ingrese entre 8 y 10 dígitos en su número de identificación"
    }
 }
 $("#cedulacodedea").attr("maxlength", "10");
 $("#cedulacodedea").attr("minlength", "8");
 $("#cedulacodedea").attr("pattern", "(.){8,10}");
 $("#cedulacodedea").attr("pattern=/^(([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9][A-Za-z0-9][A-Za-z0-9][A-Za-z0-9][A-Za-z0-9][A-Za-z0-9][A-Za-z0-9][A-Za-z0-9])$/");
</script>
<script>
    document.querySelector('input[name="edadcode"]').oninput = function () {
        if (this.value.length > 3) {
        this.value = this.value.slice(0,3); 
    }else{
        alert="Ingrese entre 1 y 3 dígitos en su número de edad"
    }
 }
 $("#edadcode").attr("maxlength", "3");
 $("#edadcode").attr("minlength", "1");
 $("#edadcode").attr("pattern", "(.){3,3}");
   </script>

<script>
    document.querySelector('input[name="pacientetelefono"]').oninput = function () {
        if (this.value.length >= 7) {
        this.value = this.value.slice(0,15); 
    }else{
        alert="Ingrese entre 7 y 15 dígitos del número telefónico"
    }
 }
 $("#pacientetelefono").attr("maxlength", "15");
 $("#pacientetelefono").attr("minlength", "7");
 $("#pacientetelefono").attr("pattern", "(.){0,15}");
   </script>
<!-- PARA MOSTRAR SOLO BOTON DE ACTIVAR RUTA VITAL-->
<script>
if (window.location.href == 'http://3.14.220.114:8000/forms/survey/mJqAMrlNbWQWeyg5Kx2n') {
    $('#nextBtn').hide();
}
</script>
<script src="../../js/jquery.validate.min.js"></script>
<script>
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
$( "#fill-form" ).validate({
  rules: {
    cedulacode: {
      required: true,
      maxlength: 10,
      minlength: 8
    },
    cedulacodedea: {
      required: true,
      maxlength: 10,
      minlength: 8
     },
     pacientetelefono: {
      required: true,
      maxlength: 15,
      minlength: 7
     }
    }
   });
</script>
<script>
var inputNumber = document.getElementById('cedulacode');
var boton = document.getElementById('nextBtn');
inputNumber.addEventListener('input', function() {
    var valor = document.getElementById('cedulacode').value.length;
    if (valor < 8) {
        boton.disabled = 'disabled';
        } else {
        boton.disabled = '';
    }
});
</script>
<script>
    var numberDir = document.getElementById('direccion-numero');
    var boton = document.getElementById('nextBtn');
    numberDir.addEventListener('input', function() {
        var valor = document.getElementById('direccion-numero').value.length;
        if (valor < 0) {
            boton.disabled = 'disabled';
            } else {
            boton.disabled = '';
        }
    });
    </script>
<script>
    // Obtener el elemento input y el botón
    var inputNumber = document.getElementById('postalcode');
    var boton = document.getElementById('nextBtn');
    // Agregar un event listener para detectar cambios en el input
    inputNumber.addEventListener('input', function() {
        // Obtener el valor del input y convertirlo a número
        var valor = document.getElementById('postalcode').value.length;
        // Verificar si el valor de caracteres es menor que 8
        if (valor < 6) {
            // Si es igual o menor que 8, agregar el estilo al botón
            boton.disabled = 'disabled';
            } else {
            // Si es mayor que 8, quitar el estilo del botón
            boton.disabled = '';
        }
    });
</script>
<script>
    var inputNumber = document.getElementById('pacientetelefono');
    var boton = document.getElementById('nextBtn');
    inputNumber.addEventListener('input', function() {
        var valor = document.getElementById('pacientetelefono').value.length;
        if (valor < 7) {
            boton.disabled = 'disabled';
            } else {
            boton.disabled = '';
        }else (valor > 15) {
            boton.disabled = 'disabled';
            } else {
            boton.disabled = '';
        }
    });
    </script>
<script>
    var inputNumber = document.getElementById('cedulacodedea');
    var boton = document.getElementById('nextBtn');
    inputNumber.addEventListener('input', function() {
        var valor = document.getElementById('cedulacodedea').value.length;
        if (valor < 8) {
            boton.disabled = 'disabled';
            } else {
            boton.disabled = '';
        }
    });
    </script>
<!-- PARA ACTIVAR LOS MODALES DE ANEXOS-->
<script>
    (function($) {
    "use strict";
        $(document).ready(function() {
            $('.modal-link').on('click', function() {
                $('body').addClass("modal-open");
            });
            $('.modal-link2').on('click', function() {
                $('body').addClass("modal-open2");
            });
            $('.close-modal').on('click', function() {
                $('body').removeClass("modal-open");
                $('body').removeClass("modal-open2");
            });
        });
}(jQuery));
</script>
<!--Rastrea ubicacion si el usuario habilita la ubicación-->
<script>
function showlocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(callback);
  } else {
    alert('Geolocalización no permitida. Verifique las configuraciones de su navegador o dispositivo.') 
  }
}
function callback(position) {
  document.getElementById('coord-lat').value = position.coords.latitude;
  document.getElementById('coord-long').value = position.coords.longitude;
}
window.onload = function () {
  showlocation();
}
</script>

<!--Verifica caracteristicas en  Contraseña del FORM ID 9-->
<script>
    document.getElementsByClassName("form-control passworddatetimefield required")[0].setAttribute("id", "passworddatetimefield");
    //var regex = /^(?=[^A-Z]*[A-Z])(?=[^!"#$%&'()*+,-.:;<=>?@[\]^_`{|}~]*[!"#$%&'()*+,-.:;<=>?@[\]^_`{|}~])(?=\D*\d).{8,}$/
</script>
<!--PARA VALIDAR LAS CONDICIONES DE LA CONTRASEÑA SOBRE CARACTERES ESPECIALES-->
<script>


//<!--PARA VALIDAR LAS CONDICIONES DE LA CONTRASEÑA SOBRE CARACTERES ESPECIALES-->
//<script>
    //document.getElementsByClassName("form-control passworddatetimefield required")[0].setAttribute("id", "passworddatetimefield");
    //var regex = /^(?=[^A-Z]*[A-Z])(?=[^!"#$%&'()*+,-.:;<=>?@[\]^_`{|}~]*[!"#$%&'()*+,-.:;<=>?@[\]^_`{|}~])(?=\D*\d).{8,}$/


    document.getElementById('passworddatetimefield').addEventListener('keyup', function(event) {
      event.preventDefault(); // Impedir el envío del formulario
      var password = document.getElementById('passworddatetimefield').value;
      // Expresión regular para comprobar si hay caracteres especiales
      //var specialCharacters = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
      // Comprobar si la contraseña cumple con los criterios
      //if (password.length < 12 || !specialCharacters.test(password)) {

      if (password.length < 12 ) {
      //if (password.length < 12.test(password)) {

        document.getElementById('errorMessage').style.display = 'block';
      } else {
        document.getElementById('errorMessage').style.display = 'none';
        // Continuar con el envío del formulario u otras acciones
        console.log('Contraseña validada exitosamente');
      }
      /** HACE VISIBLE EL CAMPO CONTRASEÑA MIENTRAS SE INGRESA, LUEGO CONVIERTE A PUNTOS**/
      var passwordField = document.getElementById('passworddatetimefield');
      passwordField.addEventListener('input', function() {
       // Cambia temporalmente el tipo de entrada a texto para mostrar caracteres
      passwordField.type = 'text';
      });
      passwordField.addEventListener('blur', function() {
      // Revertir el tipo de entrada a contraseña cuando se pierde el foco
      passwordField.type = 'password';
      });
    });    
</script>
<!--STYLES DEL MODAL-->
<style> 
.custom-modal, .custom-modal2 {
    position: fixed;
    overflow: auto;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: rgb(0 0 0 / 60%);
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    padding: 30px;
}
.custom-modal-dialog {
    max-width: 620px;
    width: 100%;
    border-radius: 0px;
    position: relative;
}
.custom-modal-content {
    background: #ffffff;
    padding: 30px 30px;
    border-radius: 10px;
}
.close-modal {
    position: absolute;
    top: -10px;
    right: -10px;
    width: auto;
    height: auto;
    background: #3366cc;
    opacity: 1;
    color: #ffffff;
    border-radius: 0;
    border: 2px solid #ffffff;
    z-index: 9;
    box-shadow: 0px 0px 30px 0px rgb(0 0 0 / 8%);
    padding: 0 20px;
    text-align: center;
    line-height: 30px;
    cursor: pointer;
}
.custom-modal,.custom-modal2{
    opacity: 0;
    visibility: hidden;
}
body.modal-open .custom-modal, body.modal-open2 .custom-modal2 {
    opacity: 1;
    visibility: visible;
}
.custom-modal .custom-modal-dialog{
    -webkit-transform: scale(0);
    -moz-transform: scale(0);
    -ms-transform: scale(0);
    -o-transform: scale(0);
    transform: scale(0);
}
body.modal-open .custom-modal .custom-modal-dialog, body.modal-open2 .custom-modal2 .custom-modal-dialog {
    -webkit-transform: scale(1);
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -o-transform: scale(1);
    transform: scale(1);
}
.custom-modal, body .custom-modal, body.modal-open .custom-modal .custom-modal-dialog, body.modal-open2 .custom-modal2 .custom-modal-dialog, body .custom-modal .custom-modal-dialog{
    -webkit-transition: all 0.5s;
    -moz-transition: all 0.5s;
    -ms-transition: all 0.5s;
    -o-transition: all 0.5s;
    transition: all 0.5s;
}

.float-right #prevBtn{
    display:none !important;
}

#fill-form > div:nth-child(3){
    display: block !important;
}
</style>
<script>
    const button = document.getElementById('button-1703767927522-0');
    button.addEventListener('click', function() {
      alert('API temporalmente deshabilitada. Respuesta no recibida del otro punto API.');
    });
  </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp2\htdocs\dea-template-pwa-last\resources\views/form/public-multi-form.blade.php ENDPATH**/ ?>