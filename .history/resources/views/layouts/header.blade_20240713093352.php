@php
    $users = \Auth::guard('api')->user();
    $currantLang = $users->currentLanguage();
    $languages = Utility::languages();
@endphp

<link rel="icon" href="../../../images/icon-192x192.png" type="image/png">
<script>
   function checkSession() {
       fetch('/check-session')
           .then(response => response.json())
           .then(data => {
               if (!data.authenticated) {
                   window.location.href = '/login';
               }
           })
           .catch(error => {
               console.error('Error al verificar la sesión:', error);
           });
   }

   // Verificar la sesión al cargar la página
   window.onload = checkSession;

   // Opcional: Verificar la sesión periódicamente
   setInterval(checkSession, 60000); // cada 60 segundos
</script>
<header class="dash-header {{ $user->transprent_layout == 1 ? 'transprent-bg' : '' }}">
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
    <div class="header-wrapper">
        <div class="mobile-container">
            <div class="mobile-menu-wrapper">
               <div class="mobile-menu-bar">
                  <div class="container-fluid">
                     <div class="row">
                        <div class="col-md-4 colsp">
                           <a href="javascript:history.back()" alt="Volver"><img src="../../images/FlechaIzq.png" alt="Volver" /></a>
                        </div>
                        <div class="col-md-4 text-center colsp colsp25">
                           <!--img src="../../images/logo-hor-AlcaldiaMedellin.png" alt="Logo Alcaldía de Medellín" /-->
                           <!--h6 class="mb-1 text-userroletitle">Usuario: { { \Auth::guard('api')->user()->name }} | Rol: { { \Auth::guard('api')->user()->rol }}</h6-->
                           @if (\Auth::guard('api')->user()->rol == "Usuario operador 1")
                           <h6 class="mb-1 text-userroletitle">Usuario: {{ \Auth::guard('api')->user()->name }}</h6>
                           @elseif (\Auth::guard('api')->user()->rol == "Usuario operador 2")
                           <h6 class="mb-1 text-userroletitle">Usuario: {{ \Auth::guard('api')->user()->name }}</h6>
                           @elseif (\Auth::guard('api')->user()->rol == "Usuario consulta E")
                           <h6 class="mb-1 text-userroletitle">Usuario: {{ \Auth::guard('api')->user()->name }}</h6>
                           @elseif (\Auth::guard('api')->user()->rol == "Consulta SSM")
                           <h6 class="mb-1 text-userroletitle">Usuario: {{ \Auth::guard('api')->user()->name }}</h6>
                           @elseif (\Auth::guard('api')->user()->rol == "Operativo SSM")
                           <h6 class="mb-1 text-userroletitle">Usuario: {{ \Auth::guard('api')->user()->name }}</h6>
                           @else
                           <h6 class="mb-1 text-userroletitle">Usuario: {{ \Auth::guard('api')->user()->name }}</h6>
                           @endif
                        </div>
                        <div class="col-md-4 tri-wrapper">
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="mobile-login-btn  text-center">
                                    <!--@ if (\Auth::guard('api')->user()->rol != "Administrador")-->
                                    @if (\Auth::guard('api')->user()->rol == "Usuario operador 1")
                                    <a href="{{ route('user-operador1.index') }}" class="top-menu-items" id="home-btn"></a>
                                    @elseif (\Auth::guard('api')->user()->rol == "Usuario operador 2")
                                    <a href="{{ route('user-operador2.index') }}" class="top-menu-items" id="home-btn"></a>
                                    @elseif (\Auth::guard('api')->user()->rol == "Usuario consulta E")
                                    <a href="{{ route('user-consultaentidad.index') }}" class="top-menu-items" id="home-btn"></a>
                                    @elseif (\Auth::guard('api')->user()->rol == "Consulta SSM")
                                    <a href="{{ route('user-consultassm.index') }}" class="top-menu-items" id="home-btn"></a>
                                    @elseif (\Auth::guard('api')->user()->rol == "Operativo SSM")
                                    <a href="{{ route('user-operativo.index') }}" class="top-menu-items" id="home-btn"></a>
                                    @else
                                    <a href="{{ route('user-administrador.index') }}" class="top-menu-items" id="home-btn"></a>
                                    @endif
                                 </div> 
                              </div>
                              <div class="col-md-4">
                                 <div class="mobile-login-btn  text-center">
                                    <a href="{{ route('profile.index') }}" class="dropdown-item top-menu-items" id="user-btn">
                                   </a>
                                 </div>
                              </div>
                              <div class="col-md-4">
                                 <div class="mobile-login-btn  text-center">
                                    <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                                    class="dropdown-item top-menu-items" id="logout-btn">
                                </a>
                                {!! Form::open([
                                    'route' => ['logout'],
                                    'method' => 'POST',
                                    'id' => 'logout-form',
                                    'class' => 'd-none',
                                ]) !!}
                                {!! Form::close() !!}
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
    </div>
</header>
