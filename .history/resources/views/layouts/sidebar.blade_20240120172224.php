@php
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
@endphp
<nav class="dash-sidebar light-sidebar {{ $user->transprent_layout == 1 ? 'transprent-bg' : '' }}">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('home') }}" class="text-center b-brand">
                <!-- ========   change your logo hear   ============ -->
                @if ($user->dark_layout == 1)
                   
                     <img src="../../images/logo.png"
                        class="app-logo" style="text-align:center; max-width:5em" />
                @else
                   
                        <img src="../../images/logo.png"
                        class="app-logo" style="text-align:center; max-width:5em"/>
                @endif
            </a>
        </div>
        <div class="navbar-content">
            <ul class="dash-navbar d-block">
                <li class="dash-item dash-hasmenu {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="dash-link"><span class="dash-micon"><i
                                class="ti ti-home"></i></span>
                        <span class="dash-mtext custom-weight">{{ __('Panel de Control') }}</span></a>
                </li>
               
                    <!--li class="dash-item dash-hasmenu { { request()->is('index-dashboard*') ? 'active' : '' }}">
                        <a href="{ { route('index.dashboard') }}" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-square"></i></span>

                            <span class="dash-mtext custom-weight">{ { __('Gráficos del Panel') }}</span></a>
                    </li-->
             
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('users*') || request()->is('roles*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-layout-2"></i></span><span

                                class="dash-mtext">{{ __('Gestión de Usuarios') }}</span><span class="dash-arrow"
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                           
                                <li class="dash-item {{ request()->is('users*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('users.index') }}">{{ __('Usuarios') }}</a>
                                </li>
                           
                                <li class="dash-item {{ request()->is('roles*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('roles.index') }}">{{ __('Roles') }}</a>
                                </li>
                        </ul>
                    </li>
                
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('forms*', 'design*') || request()->is('form-values*') || request()->is('form-template*') || request()->is('form-template/design*') ? 'active dash-trigger' : 'collapsed' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i class="ti ti-table"></i></span><span
                                class="dash-mtext">{{ __('Formularios') }}</span><span class="dash-arrow"><i
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                           
                                <li class="dash-item {{ request()->is('forms*', 'design*') ? 'active' : '' }}">
                                    <a class="dash-link" href="{{ route('forms.index') }}">{{ __('Formularios') }}</a>
                                </li>
                                
                                <li class="dash-item">
                                    <a href="#!" class="dash-link"><span
                                            class="dash-mtext custom-weight">{{ __('Forms completados') }}</span><span
                                            class="dash-arrow"><i data-feather="chevron-right"></i></span></a>
                                    <ul
                                        class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
                                        @foreach ($forms as $form)
                                            <li class="dash-item">
                                                <a class="dash-link {{ Request::route()->getName() == 'view.form.values' ? 'show' : '' }}"
                                                    href="{{ route('view.form.values', $form->id) }}">{{ $form->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                
                        </ul>
                    </li>
               
               
                    <li
                        class="dash-item dash-hasmenu {{ request()->is('mailtemplate*') || request()->is('sms-template*') || request()->is('manage-language*') || request()->is('create-language*') || request()->is('settings*') ? 'active dash-trigger' : 'collapsed' }} || {{ request()->is('create-language*') || request()->is('settings*') ? 'active' : '' }}">
                        <a href="#!" class="dash-link"><span class="dash-micon"><i
                                    class="ti ti-apps"></i></span><span

                                class="dash-mtext">{{ __('Gestión de Cuenta') }}</span><span class="dash-arrow"
                                    data-feather="chevron-right"></i></span></a>
                        <ul class="dash-submenu">
                          
                                <li class="dash-item {{ request()->is('mailtemplate*') ? 'active' : '' }}">
                                    <a class="dash-link"
                                        href="{{ route('mailtemplate.index') }}">{{ __('Plantillas de correo') }}</a>
                                </li>
                          
                            
                                <li class="dash-item {{ request()->is('settings*') ? 'active' : '' }}">

                                    <a class="dash-link" href="{{ route('settings') }}">{{ __('Configuración') }}</a>
                                </li>
                           
                        </ul>
                    </li>
                            
            </ul>
        </div>
    </div>
</nav>
