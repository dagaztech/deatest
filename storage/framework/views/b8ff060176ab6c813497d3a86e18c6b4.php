<?php $__env->startSection('title', __('Registro y gestión de espacios o lugares')); ?>


<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Bienvenido Administrador UGIC</h5>
                    </div>
                    <div class="card-body form-card-body">
                      <div class="btns-vertical-wrapper"> 
                        <div class="row">
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
                               <a href="/forms/survey/B9RO37N1aMAaWmpnyxV8" alt="Registro y gestión de espacios o lugares">Registro y gestión de espacios o lugares</a>
                            </div>
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="orange-btn">
                                <a href="/forms/survey/wX90Gz3YaOpbxqlW142B" alt="Registro y gestión de usuario">Registro y gestión de usuario</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="<?php echo e(route('user-administrador.gestion-informacion')); ?>" alt="Gestión y parametrización de información">Gestión y parametrización de información</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
                                <a href="<?php echo e(route('user-administrador.reportes-useradmin')); ?>" alt="Consulta de reportes">Consulta de reportes</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="<?php echo e(route('user-administrador.tableros-useradmin')); ?>" alt="Visualización de tableros">Visualización de tableros</a>
                             </div>
                        </div>
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



<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\dea-template-pwa-last\resources\views/user-administrador/index.blade.php ENDPATH**/ ?>