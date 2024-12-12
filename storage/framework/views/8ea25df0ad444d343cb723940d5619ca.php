
<?php $__env->startSection('title', __('Gestión de información')); ?>


<div class="section-body">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card" >
                <div class="card" id="green-btn">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Gestión de información</h5>
                    </div>
                    <div class="card-body form-card-body">
                      

                        <div class="row">
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                               <a href="/form-values/7/view" alt="Información de espacios o lugares">Información de espacios o lugares</a>
                            </div>
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="/form-values/9/view" alt="Información de usuarios">Información de usuarios</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="/form-values/33/view" alt="Información de reporte de instalación">Información de reporte de
instalación</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="/form-values/14/view" alt="Información de reporte de uso">Información de reporte de uso</a>
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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\dea-template-pwa-last\resources\views/user-administrador/gestion-informacion.blade.php ENDPATH**/ ?>