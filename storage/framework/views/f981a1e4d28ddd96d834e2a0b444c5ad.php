<?php $__env->startSection('title', __('Eventos Criticos Activos')); ?>


<div class="section-body normal-width">
  <div class="mx-0 mt-5 row">
    <div class="mx-auto col-md-12 rounded-card">
      <div class="card" id="green-btn">
        <div class="card-header">
          <h5 class="text-center w-100" id="new-title">Eventos Criticos Activos</h5>
        </div>
        <div class="card-body form-card-body">
          <div class="row">
            <div id="map" style="height: 400px; width: 100%;"></div>
            <h2>Eventos Criticos Activos</h2>
            <p>Haga clic sobre el evento crítico que desea ubicar en el mapa</p>
            <!--SE ALIMENTA DESDE FORMULARIO 12-->
            <table class="eventos-tabla tablas-mapa">
              <thead>
                <tr>
                  <th>Nombre del DEA</th>
                  <th>Latitud</th>
                  <th>Longitud</th>
                </tr>
              </thead>
              <tbody >
               



                <?php $__currentLoopData = $coordenadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coordenada): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr latitud="<?php echo e($coordenada['latitud']); ?>"  longitud="<?php echo e($coordenada['longitud']); ?>" onclick="mostrarMapa(this)">
                        <td><?php echo e($coordenada["dea"]); ?></td>
                        <td><?php echo e($coordenada["latitud"]); ?></td>
                        <td><?php echo e($coordenada["longitud"]); ?></td>
                      </tr>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>







              </tbody>
            </table>
          </div>
        </div>
        <div class="forms-footer">
          <div class="footer-bottom footer-mobile">
            <div class="footer_gov_">
              <div class="centradototal_ fooflex">
                <div class="logos_footer_gov">
                  <a href="https://www.colombia.co" target="_blank">
                    <img class="marcaco_l" src="../../images/logo.png" alt="colombia.co">
                  </a>
                </div>
                <div class="alcaldia_mod_footer">
                  <a href="https://www.medellin.gov.co/es">
                    <img class="log_nww_footer" src="../../images/logo_nav_footer.png" alt="Alcaldía de Medellín">
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php $__env->startPush('script'); ?>

<!--INICIALIZA EL MAPA DE MEDELLIN-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJpAt97dzsQgg4c6XA7IpE4Ig70RvlgG4&callback=initMap&libraries=places"></script>
<script>
  function showMap(lat, long) {
    var coord = {
      lat: lat,
      lng: long
    };
    var map = new google.maps.Map(document.getElementById("map"), {
      zoom: 14,
      center: coord
    });
    new google.maps.Marker({
      position: coord,
      map: map
    });
  }
  showMap(6.217, -75.567);


  function mostrarMapa(elemento){
              showMap(+$(elemento).attr("latitud"), +$(elemento).attr("longitud"))
            }
</script>
    <style>
      .tablas-mapa tr th, .tablas-mapa tr td{
          width: 33% !important;
      }
      .tablas-mapa tr,.tablas-mapa tr:hover{
                cursor:pointer;
            }
      .tablas-mapa tr th{
text-align: center;
padding: 0.5em;
background: #eee;
}
      .tablas-mapa, .tablas-mapa tr td {
text-align: center;
border: 1px solid #eee;
padding: 0.5em;
width: 98%;
margin: 1%;
}</style>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/user-consultassm/eventos-criticosactivos.blade.php ENDPATH**/ ?>