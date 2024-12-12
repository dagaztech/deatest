
<?php $__env->startSection('title', __('Histórico de Usuarios')); ?>

<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Histórico de Usuarios</h5>
                    </div>
                    <div class="card-body form-card-body">
                      <div class="btns-vertical-wrapper">
                        <div class="row">
                    <?php echo $__env->make('user-operativo.tabla-historicousuarios', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp2\htdocs\dea-template-pwa-last\resources\views/user-operativo/historico-usuarios.blade.php ENDPATH**/ ?>