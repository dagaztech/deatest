<?php $__env->startSection('title', __('Agendamiento, Planeación y Reportes')); ?>

<div class="section-body normal-width">
    <div class="mx-0 mt-5 row"> 
        <div class="mx-auto col-md-12 rounded-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Agendamiento, Planeación y Reportes</h5>
                    </div>
                    <div class="card-body form-card-body">
                      <div class="btns-vertical-wrapper"> 
                        <div class="row">
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="<?php echo e(route('user-consultassm.consssm-agendamiento')); ?>" alt="Agendamiento">Agendamiento</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="<?php echo e(route('user-consultassm.consssm-planeacion')); ?>" alt="Planeación">Planeación</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="<?php echo e(route('user-consultassm.consssm-seguimiento')); ?>" alt="Seguimiento">Seguimiento</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="<?php echo e(route('user-administrador.reportes-useradmin')); ?>" alt="Reportes">Reportes</a>
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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\dea-template-pwa-last\resources\views/user-consultassm/agendamiento-planesrepo.blade.php ENDPATH**/ ?>