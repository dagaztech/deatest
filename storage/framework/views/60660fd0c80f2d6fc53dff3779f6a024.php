
<?php $__env->startSection('title', __('Información de Espacios')); ?>

<div class="mobile-container">
   <div class="mobile-menu-wrapper">
      <div class="mobile-menu-bar">
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-4 colsp">
                  <a href="#" alt="Volver"><img src="../../images/FlechaIzq.png" alt="Volver" /></a>
               </div>
               <div class="col-md-4 text-center colsp colsp25">
                  <img src="../../images/logo-hor-AlcaldiaMedellin.png" alt="Logo Alcaldía de Medellín" />
               </div>
               <div class="col-md-4 tri-wrapper">
                  <div class="row">
                     <div class="col-md-4">
                        <div class="mobile-login-btn  text-center">
                           <a href="#inicio" class="top-menu-items" id="home-btn"> <!--<?php echo e(__('Previous')); ?>--></a>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mobile-login-btn  text-center">
                           <a href="#profile" class="top-menu-items" id="user-btn"> <!--<?php echo e(__('Profile')); ?>--></a>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mobile-login-btn  text-center">
                           <a href="#logout" class="top-menu-items" id="logout-btn"> <!--<?php echo e(__('Logout')); ?>--></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="section-body">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card" >
                <div class="card" id="green-btn">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Información de Espacios</h5>
                    </div>
                    <div class="card-body form-card-body">
                        <div class="row">
                            <!--Insertar tabla-->

                        </div>
                    </div>
                </div>
        </div>
    </div>
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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\andresmauriciogomezr\Documents\proyectos\dea-template-pwa\resources\views/user-administrador/informacion-espacios.blade.php ENDPATH**/ ?>