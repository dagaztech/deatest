<?php $__env->startSection('title', __('Histórico de Usuarios')); ?>

<?php $__env->startSection('breadcrumb'); ?>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.0/css/buttons.dataTables.css" />
<?php $__env->stopSection(); ?>

<script>
    // Añade un evento para ejecutar el código cuando la página se haya cargado
    window.addEventListener('load', function() {
        const divHistorical = document.getElementById('historical');
        divHistorical.style.display = 'block'; // Muestra el div
    });
</script>

    <style>
#historical {
            display: none; /* Oculta el div inicialmente */
        }
</style>
<div class="section-body normal-width" id="historical">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Histórico de Usuarios</h5>
                    </div>
                    <div class="card-body form-card-body">
                      <div class="btns-vertical-wrapper">

                        <div class="row">

                            <form method="post" action="<?php echo e(url('user-operativo/historico-usuarios')); ?>" class="filtrador">
                            <?php echo csrf_field(); ?> 
                    <input class="form-control mr-1 created_at flatpickr-input" placeholder="Selecciona rango de fechas" id="pc-daterangepicker-1" onchange="updateEndDate()" name="rango" type="text" readonly="readonly">                                   
                     <input type="submit" value="Filtrar" class="sbmt-btn">
                            </form>
                        </div>

                        <div class="row">
                            <table id="tabla" class="table">
                                <thead>
                                    <tr>
                                        <th><label>No</label></th>
                                        <th><label>Fecha</label></th>
                                        <th><label>Usuario</label></th>
                                        <th><label>Descripción</label></th>
                                        <th><label>Dirección Ip</label></th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $listaHistoricos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  
                                    <tr>
                                        <td><?php echo e($column +1); ?></td>
                                        <td><?php echo e($value->created_at); ?></td>
                                        <td><?php echo e($value->name); ?> - <?php echo e($value->email); ?></td>
                                        <td><?php echo e($value->description); ?></td>
                                        <td><?php echo e($value->ip); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </thead>
                                </tbody>
                            </table>


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
<?php $__env->startPush('script'); ?>



<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" ></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js" ></script>
 

  <script>

        $(document).ready(function(){

            $('#tabla').DataTable( {
                "language": {
                  "search": "Buscar:",
                  "lengthMenu": "Mostrando _MENU_ filas por página",
                  "emptyTable": "Ningún registro disponible",
                  "zeroRecords": "Ningún elemento encontrado",
                  "infoEmpty": "Ningún registro disponible",
                  "infoFiltered": "(filtrados de _MAX_ registros totales)",
                  "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                  "oPaginate" : {
                  "sFirst": "Primero", "sLast": "Último", "sNext": "Siguiente", "sPrevious": "Anterior"}
                },
                dom: 'Bfrtip',
                buttons: ['csv', 'excel'],

            } );


         });
    </script>
    <script>
        
      
        document.querySelector("#pc-daterangepicker-1").flatpickr({
            mode: "range",
            mode: "range",
                maxDate: "today",
                locale: {
        firstDayOfWeek: 1,
        weekdays: {
          shorthand: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
          longhand: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],         
        }, 
        months: {
          shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
          longhand: ['Enero', 'Febreo', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        },
      },
    dateFormat: "Y-m-d",
    disable: [
        function(date) {
            return !(date.getDate());
        }
    ]
        });
    </script>
    <script>
        function updateEndDate() {
            var duration = document.getElementById('pc-daterangepicker-1').value;
            var startDate = '';
            var startDateArray = duration.split(' - ');
            if (startDateArray.length > 0) {
                startDate = startDateArray[0];
            }
            document.querySelector('input[name="select_date"]').value = startDate;
        }
    </script>


    <style>
    .dataTables_info{
    text-align: center;
    margin: 2em;
}
#tabla_paginate{
    text-align: center;
}

.form-control.mr-1.created_at.flatpickr-input{
    width: 80%;
    float: left;
}
.sbmt-btn {
    margin-left: 1em;
    line-height: 2em;
    padding-left: 1em;
    padding-right: 1em;
    color: #fff;
    background-color: #0275d8;
    font-size: 16px;
    border-radius: 0.3rem;
    border: solid 1px #0275d8;
}
.dt-buttons{
    float:right;
}
div.dt-buttons > .dt-button{
    color: #fff !important;
    background-color: #5cb85c  !important;
    border-color: #5cb85c  !important;
}
input[type=search]{
    margin-left: 1em;
    border: 1px solid gray;
}
.paginate_button{
    padding: 0.5em 0.75em;
    margin: 5px;
    border-radius: 0.3rem;
}
.paginate_button:hover{
    cursor:pointer;
}
.paginate_button.current{
    background: #deeffd;
}
.paginate_button.previous, .paginate_button.next{
    color: #000 !important;
    background-color: #cecece  !important;
    border-color: #cecece  !important;
}
.paginate_button.previous{
    float: left;
}
.paginate_button.next{
    float: right;
}
div.dataTables_wrapper {
    position: relative;
    overflow-x: scroll;
}
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/user-operativo/historico-usuarios.blade.php ENDPATH**/ ?>