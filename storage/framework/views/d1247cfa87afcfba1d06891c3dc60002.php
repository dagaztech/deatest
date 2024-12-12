<?php
    use App\Models\Form;
    use App\Models\Booking;
    $user = \Auth::guard('api')->user();
    $currantLang = $user->currentLanguage();
    $languages = Utility::languages();
    //$role_id = $user->roles->first()->id;
    $role_id = $user->rol;
    $user_id = $user->id;
    if (Auth::guard('api')->user()->type == 'Admin') {
        $forms = Form::all();
        $all_forms = Form::all();
        $bookings = Booking::all();
    } else {
        $forms = Form::select(['forms.*'])->where(function ($query) use ($role_id, $user_id) {
            $query
                ->whereIn('forms.id', function ($query1) use ($role_id) {
                    $query1
                        ->select('form_id')
                        ->from('assign_forms_roles')
                        ->where('role_id', $role_id);
                })
                ->OrWhereIn('forms.id', function ($query1) use ($user_id) {
                    $query1
                        ->select('form_id')
                        ->from('assign_forms_users')
                        ->where('user_id', $user_id);
                });
        });
        $bookings = Booking::all();
        $all_forms = Form::select('id', 'title')
            ->where('created_by', $user->id)
            ->get();
    }
    $bookings = $bookings->all();
?>
<nav class="dash-sidebar light-sidebar <?php echo e($user->transprent_layout == 1 ? 'transprent-bg' : ''); ?>">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="<?php echo e(route('home')); ?>" class="text-center b-brand">
                <!-- ========   change your logo hear   ============ -->
                <?php if($user->dark_layout == 1): ?>
                   
                     <img src="../../images/logo.png"
                        class="app-logo" style="text-align:center; max-width:5em" />
                <?php else: ?>
                   
                        <img src="../../images/logo.png"
                        class="app-logo" style="text-align:center; max-width:5em"/>
                <?php endif; ?>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar d-block">
                <li class="dash-item dash-hasmenu <?php echo e(request()->is('/') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('home')); ?>" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight"><?php echo e(__('Panel de Control')); ?></span></a>
                </li>
               
                    <li class="dash-item dash-hasmenu <?php echo e(request()->is('index-dashboard*') ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('index.dashboard')); ?>" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-square"></i></span>

                            <span class="dash-mtext custom-weight"><?php echo e(__('Gráficos del Panel')); ?></span></a>
                    </li>
             
                    <li
                        class="dash-item dash-hasmenu <?php echo e(request()->is('users*') || request()->is('roles*') ? 'active dash-trigger' : 'collapsed'); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-layout-2"></i></span><span

                                class="dash-mtext"><?php echo e(__('Gestión de Usuarios')); ?></span><span class="dash-arrow"
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                           
                                <li class="dash-item <?php echo e(request()->is('users*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('users.index')); ?>"><?php echo e(__('Usuarios')); ?></a>
                                </li>
                           
                                <li class="dash-item <?php echo e(request()->is('roles*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('roles.index')); ?>"><?php echo e(__('Roles')); ?></a>
                                </li>
                        </ul>
                    </li>
                
                    <li
                        class="dash-item dash-hasmenu <?php echo e(request()->is('forms*', 'design*') || request()->is('form-values*') || request()->is('form-template*') || request()->is('form-template/design*') ? 'active dash-trigger' : 'collapsed'); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-table"></i></span><span
                                class="dash-mtext"><?php echo e(__('Formularios')); ?></span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                           
                                <li class="dash-item <?php echo e(request()->is('forms*', 'design*') ? 'active' : ''); ?>">
                                    <a class="dash-link" href="<?php echo e(route('forms.index')); ?>"><?php echo e(__('Formularios')); ?></a>
                                </li>
                           
                                <li class="dash-item">
                                    <a href="#!" class="dash-link"><span
                                            class="dash-mtext custom-weight"><?php echo e(__('Formularios Diligenciados')); ?></span><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul
                                        class="dash-submenu <?php echo e(Request::route()->getName() == 'view.form.values' ? 'd-block' : ''); ?>">
                                        <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="dash-item">
                                                <a class="dash-link <?php echo e(Request::route()->getName() == 'view.form.values' ? 'show' : ''); ?>"
                                                    href="<?php echo e(route('view.form.values', $form->id)); ?>"><?php echo e($form->title); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                        </ul>
                    </li>
               
               
                    <li
                        class="dash-item dash-hasmenu <?php echo e(request()->is('mailtemplate*') || request()->is('sms-template*') || request()->is('manage-language*') || request()->is('create-language*') || request()->is('settings*') ? 'active dash-trigger' : 'collapsed'); ?> || <?php echo e(request()->is('create-language*') || request()->is('settings*') ? 'active' : ''); ?>">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-apps"></i></span><span

                                class="dash-mtext"><?php echo e(__('Gestión de Cuenta')); ?></span><span class="dash-arrow"
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                          
                                <li class="dash-item <?php echo e(request()->is('mailtemplate*') ? 'active' : ''); ?>">
                                    <a class="dash-link"
                                        href="<?php echo e(route('mailtemplate.index')); ?>"><?php echo e(__('Plantillas de correo')); ?></a>
                                </li>
                          
                            
                                <li class="dash-item <?php echo e(request()->is('settings*') ? 'active' : ''); ?>">

                                    <a class="dash-link" href="<?php echo e(route('settings')); ?>"><?php echo e(__('Configuración')); ?></a>
                                </li>
                           
                        </ul>
                    </li>
                            
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH C:\Users\andresmauriciogomezr\Documents\proyectos\dea-template-pwa\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>