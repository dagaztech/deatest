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

<label for="menu-control" class="hamburger">
    <i class="hamburger__icon"></i>
    <i class="hamburger__icon"></i>
    <i class="hamburger__icon"></i>
  </label>
<nav class="dash-sidebar light-sidebar {{ $user->transprent_layout == 1 ? 'transprent-bg' : '' }}">
    <div class="navbar-wrapper">
        <!--div class="m-header">
            <a href="{ { route('home') }}" class="text-center b-brand">
                <! -- ========   change your logo hear   ============ - ->
                @ if ($user->dark_layout == 1)
                   
                     <img src="../../images/logo.png"
                        class="app-logo" style="text-align:center; max-width:5em" />
                @ else
                   
                        <img src="../../images/logo.png"
                        class="app-logo" style="text-align:center; max-width:5em"/>
                @ endif
            </a>
        </div-->
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
                                    <ul class="dash-submenu">
                                            <li class="dash-item">
                                                <a class="filledforms dash-link " href="/form-values/9/view">Registro de Usuario Operador</a>
                                            </li>
                                            <li class="dash-item">
                                                <a class="filledforms dash-link" href="/form-values/31/view">Registro de Representante Legal</a>
                                            </li>
                                            <li class="dash-item">
                                                <a class="filledforms dash-link" href="/form-values/30/view">Registro de DEA's</a>
                                            </li>
                                            <li class="dash-item">
                                                <a class="filledforms dash-link" href="/form-values/7/view">Registro de Espacios de Instalación</a>
                                            </li>
                                            <li class="dash-item">
                                                <a class="filledforms dash-link" href="/form-values/10/view">Personal Certificado Uso DEA</a>
                                            </li>
                                            <li class="dash-item">
                                                <a class="filledforms dash-link" href="/form-values/13/view">Información Evento Cardiovascular</a>
                                            </li>
                                            <li class="dash-item">
                                                <a class="filledforms dash-link" href="/form-values/14/view">Reporte Uso del DEA</a>
                                            </li>
                                            <li class="dash-item">
                                                <a class="filledforms dash-link" href="/form-values/12/view">Evento Cardiovascular en Curso</a>
                                            </li>
                                            <li class="dash-item">
                                                <a class="filledforms dash-link" href="/form-values/19/view">Creación Plan de Acción</a>
                                            </li>
                                            <li class="dash-item">
                                                <a class="filledforms dash-link" href="/form-values/18/view">Creación Acta de Visita</a>
                                            </li>
                                            <li class="dash-item">
                                                <a class="filledforms dash-link" href="/form-values/17/view">Agendamientos Visitas</a>
                                            </li>

                                        </li>
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
@push('style')
//I'm Using SCSS
html, body {
  height: 100%;
}

body {
  min-height: 100%;
  font-family: 'Rozha One', serif;
}

* {
  box-sizing: border-box;
}

img {
  max-width: 100%;
  bottom: -14px;
  position: relative;
}

.card {
  position: absolute;
  bottom: 5%;
  right: 5%;
  text-align: center;
  color: #272243;
  width: 100%;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 0 20px 20px rgba(0,0,0,0.03);
  width: 320px;
  overflow: hidden;
  animation: updown 3s ease 6;
  
  &::before {
    content: "";
    border-width: 20px;
    border-color: transparent;
    border-style: solid;
    border-left-color: rgba(255,255,255, 0.9);
    border-left-width: 30px;
    display: block;
    position: absolute;
    top: 55%;
    left: 50%;
    z-index: 2;
    transform: translatex(calc(-50% + 15px));
    filter: drop-shadow(5px 5px 4px #000);
    pointer-events: none;
  }
  
  h1 {
    margin: 0;
    padding: 10px;
    font-size: 16px;
  }
  
  @keyframes updown {
    0%, 50%, 100% {
      transform: translatey(0);
    }
    20% {
      transform: translatey(5px);
    }
    25% {
      transform: translatey(-20px);
    }
    30% {
      transform: translatey(20px);
    }
    35% {
      transform: translatey(-5px);
    }
  }
}

.banner {
  min-height: 100%;
  width: 100%;
  background: url('https://i.imgur.com/T57flD5.jpg');
  background-size: cover;
  display: flex;
  align-items: center;
  padding: 60px;
  color: #fff;
}

.hamburger {
  position: absolute;
  left: 30px;
  top: 30px;
  display: flex;
  height: 18px;
  width: 24px;
  flex-direction: column;
  justify-content: space-between;
  cursor: pointer;
  user-select: none;
  z-index: 1;
  
  &__icon {
    display: inline-block;
    height: 2px;
    width: 24px;
    background: #fff;
    border-radius: 2px;
  }
}

.sidebar {
  height: 100vh;
  width: 320px;
  background: #fff;
  position: absolute;
  top: 0;
  left: 0;
  padding: 0 60px;
  display: flex;
  flex-direction: column;
  transform: translatex(-100%);
  transition: transform 0.4s ease-in-out;
  
  &__close {
    position: absolute;
    top: 50%;
    right: -30px;
    background: #fff;
    height: 60px;
    width: 60px;
    border-radius: 50%;
    box-shadow: 0 0 20px 20px rgba(0,0,0,0.03);
    display: flex;
    justify-content: center;
    align-items: center;
    transform: translatex(-100%);
    cursor: pointer;
    transition: transform 0.4s ease-in-out 0.2s;
    
    &::before, 
    &::after {
      content: "";
      height: 2px;
      background: #898989;
      width: 24px;
      display: block;
      position: absolute;
    }
    
    &::after {
      transform: rotate(90deg);
    }
  }
  
  &__menu { //it's means sidebar__menu
    display: flex;
    flex-direction: column;
    flex: 1;
    justify-content: space-around;
    font-size: 36px;
    margin-top: 80px;
    margin-bottom: 80px;
    color: #898989;
    
    a {
      color: currentcolor;
      text-decoration: none;
      transform: translatex(-80%);
      transition: transform 0.4s ease-in-out;
      
      &::before {
        content: "";
        height: 2px;
        background: #898989;
        width: 120px;
        position: absolute;
        bottom: -2px;
        left: 0;
        transform: translatex(-50%);
        opacity: 0;
        transition: transform 0.4s ease-in-out, opacity 0.4s linear;
      }
      
      &:hover {
        &::before {
          transform: translatex(0);
          opacity: 1;
        }
      }
      
      @for $i from 1 through 5 {
        &:nth-child(#{$i}) {
          transition-delay: $i * 0.05s;
        }
      }
    }
  }
  
  &__social {
    display: flex;
    list-style: none;
    padding: 0;
    
    li {
      margin: 4px;
    }
    
    a, svg {
      display: inline-block;
      height: 18px;
      width: 18px;
    }
  }
}

.menu-control {
  display: none;
  
  &:checked {
    & + .sidebar {
      transform: translatex(0);
    }
    
    & + .sidebar .sidebar__close {
      transform: translatex(0) rotate(45deg);
    }
    
    & + .sidebar .sidebar__menu a {
      transform: translatex(0);
    }
  }
}
@endpush