<?php $__env->startSection('title', __('Consulta SSM')); ?>
 

<div class="section-body normal-width">
    <div class="mx-0 mt-5 row"> 
        <div class="mx-auto col-md-12 rounded-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Bienvenido a Consultas SSM</h5>
                    </div>
                    <div class="card-body form-card-body">
                      <div class="btns-vertical-wrapper"> 
                        <div class="row">
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
                               <a href="<?php echo e(route('user-consultassm.regequipos-dea')); ?>" alt="Consulta de Registro de Equipos DEA">Consulta de Registro de Equipos DEA</a>
                            </div>
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="orange-btn">
                                <a href="<?php echo e(route('user-consultassm.consultauso-dea')); ?>" alt="Consulta de Uso de los DEA">Consulta de Uso de los DEA</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="<?php echo e(route('user-consultassm.agendamiento-planesrepo')); ?>" alt="Agendamiento, Planeación y Reportes">Agendamiento, Planeación y Reportes</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
                                <a href="<?php echo e(route('user-administrador.tableros-useradmin')); ?>" alt="Visualización de reportes">Visualización de tableros </a>
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
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\dea-template-pwa-last\resources\views/user-consultassm/index.blade.php ENDPATH**/ ?>