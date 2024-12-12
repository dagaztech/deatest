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

<input type="checkbox" id="check">
<label for="check">
  <i class="fas fa-bars" id="btn"></i>
  <i class="fas fa-times" id="cancel"></i>
</label>
<nav class="dash-sidebar sidebar light-sidebar {{ $user->transprent_layout == 1 ? 'transprent-bg' : '' }}">
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
                                                <a class="filledforms dash-link" href="/form-values/33/view">Registro de DEA's</a>
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

@push('script')
<style> 
*{
    margin: 0;
    padding: 0;
    text-decoration: none;
  }
  :root {
    --accent-color: #fff;
    --gradient-color: #FBFBFB;
  }
  body{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
     width: 100vw;
    height: 100vh;
    background-image: linear-gradient(-45deg, #e3eefe 0%, #efddfb 100%);
  }
  
  .sidebar{
    position: fixed;
    width: 260px;
    left: -260px;
    height: 100%;
    background-color: #fff;
    transition: all .5s ease;
  }

  /*a.active,a:hover{
    border-left: 5px solid var(--accent-color);
    color: #fff;
     background: linear-gradient(to left, var(--accent-color), var(--gradient-color));
  }*/
  #check{
    display: none;
  }
  label #btn, label #cancel {
    position: absolute;
    left: 0;
    cursor: pointer;
    color: #ffffff;
    border-radius: 5px;
    margin: 15px 30px;
    font-size: 29px;
    background-color: #5ac1dd;
    height: 45px;
    width: 45px;
    text-align: center;
    line-height: 45px;
    transition: all .5s ease;
    bottom:0px;
}
  label #cancel{
    opacity: 0;
    visibility: hidden;
  }
  #check:checked ~ .sidebar{
    left: 0;
  }
  #check:checked ~ label #btn{
    margin-left: 265px;
    opacity: 0;
    visibility: hidden;
  }
  #check:checked ~ label #cancel{
    margin-left: 265px;
    opacity: 1;
    visibility: visible;
  }
  @media(max-width : 860px){
    .sidebar{
      height: auto;
      width: 70px;
      left: 0;
      margin: 100px 0;
    }
    header,#btn,#cancel{
      display: none;
    }
    span{
      position: absolute;
      margin-left: 23px;
      opacity: 0;
      visibility: hidden;
    }
    .sidebar a{
      height: 60px;
    }
    .sidebar a i{
      margin-left: -10px;
    }
    a:hover {
      width: 200px;
      background: inherit;
    }
    .sidebar a:hover span{
      opacity: 1;
      visibility: visible;
    }
  }
  
  .sidebar > a.active,.sidebar > a:hover:nth-child(even) {
    --accent-color: #52d6f4;
    --gradient-color: #c1b1f7;
  }
  .sidebar a.active,.sidebar > a:hover:nth-child(odd) {
    --accent-color: #c1b1f7;
    --gradient-color: #A890FE;
  }
  
  .frame {
    width: 50%;
    height: 30%;
    margin: auto;
    text-align: center;
  }
  
</style> 
@endpush