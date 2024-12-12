<?php
    $users = \Auth::guard('api')->user();
    $currantLang = $users->currentLanguage();
    $languages = Utility::languages();
?>

<link rel="icon" href="../../../images/icon-192x192.png" type="image/png">
<script>
   function checkSession() {
       fetch('/check-session')
           .then(response => response.json())
           .then(data => {
               if (!data.authenticated) {
                   window.location.href = 'https://dea.wearesmart.co/login';
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
<script>
   // Función para añadir el manejo de cierre de sesión a los enlaces
   function addLogoutHandler() {
       document.querySelectorAll('a[href="https://dea.wearesmart.co/logout"]').forEach(anchor => {
           anchor.addEventListener('click', function(event) {
               event.preventDefault(); // Evitar la navegación predeterminada
               fetch('/logout', {
                   method: 'POST',
                   headers: {
                       'Content-Type': 'application/json',
                       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                   }
               })
               .then(response => {
                   if (response.ok) {
                       window.location.href = 'https://dea.wearesmart.co/login';
                   }
               })
               .catch(error => {
                   console.error('Error al cerrar la sesión:', error);
               });
           });
       });
   }

   // Función para redirigir a la página de login si la URL actual es "/logout"
   function redirectIfLogoutUrl() {
       if (window.location.pathname === 'https://dea.wearesmart.co/logout') {
           window.location.href = 'https://dea.wearesmart.co/login';
       }
   }

   // Llamar a las funciones al cargar la página
   window.onload = function() {
       addLogoutHandler();
       redirectIfLogoutUrl();
   };
</script>
<header class="dash-header <?php echo e($user->transprent_layout == 1 ? 'transprent-bg' : ''); ?>">
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
                          <?php if(\Auth::guard('api')->user()->rol == "Usuario operador 1"): ?>
                           <h6 class="mb-1 text-userroletitle">Usuario: <?php echo e(\Auth::guard('api')->user()->name); ?></h6>
                           <?php elseif(\Auth::guard('api')->user()->rol == "Usuario operador 2"): ?>
                           <h6 class="mb-1 text-userroletitle">Usuario: <?php echo e(\Auth::guard('api')->user()->name); ?></h6>
                           <?php elseif(\Auth::guard('api')->user()->rol == "Usuario consulta E"): ?>
                           <h6 class="mb-1 text-userroletitle">Usuario: <?php echo e(\Auth::guard('api')->user()->name); ?></h6>
                           <?php elseif(\Auth::guard('api')->user()->rol == "Consulta SSM"): ?>
                           <h6 class="mb-1 text-userroletitle">Usuario: <?php echo e(\Auth::guard('api')->user()->name); ?></h6>
                           <?php elseif(\Auth::guard('api')->user()->rol == "Operativo SSM"): ?>
                           <h6 class="mb-1 text-userroletitle">Usuario: <?php echo e(\Auth::guard('api')->user()->name); ?></h6>
                           <?php else: ?>
                           <h6 class="mb-1 text-userroletitle">Usuario: <?php echo e(\Auth::guard('api')->user()->name); ?></h6>
                           <?php endif; ?>
                        </div>
                        <div class="col-md-4 tri-wrapper">
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="mobile-login-btn  text-center">
                                    <!--@ if (\Auth::guard('api')->user()->rol != "Administrador")-->
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
    </div>
</header>
<?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/layouts/header.blade.php ENDPATH**/ ?>