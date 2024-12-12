<?php
    $users = \Auth::guard('api')->user();
    $currantLang = $users->currentLanguage();
    $languages = Utility::languages();
?>
<header class="dash-header <?php echo e($user->transprent_layout == 1 ? 'transprent-bg' : ''); ?>">
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
                           <img src="../../images/logo-hor-AlcaldiaMedellin.png" alt="Logo Alcaldía de Medellín" />
                        </div>
                        <div class="col-md-4 tri-wrapper">
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="mobile-login-btn  text-center">
                                    <a href="<?php echo e(route('home')); ?>" class="top-menu-items" id="home-btn"></a>
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
<?php /**PATH C:\Users\andresmauriciogomezr\Documents\proyectos\dea-template-pwa\resources\views/layouts/header.blade.php ENDPATH**/ ?>