
<?php $__env->startSection('title', __('Tableros de Uso e Instalación de DEA')); ?>


<div class="section-body normal-width">



    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
          <div class="tableros-wrapper">
                <div class="card"  id="purple-btn">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Tableros de Uso e Instalación de DEA</h5>
                    </div>
                    <div class="card-body form-card-body">
                    
                      <form method="post" action="<?php echo e(url('user-administrador/tableros-useradmin')); ?>">
                        <?php echo csrf_field(); ?> 
            
                        <div class="row">
            
                         <!--div class="form-group d-flex justify-content-start col-sm-4">
                            <input class="form-control mr-1 " placeholder="Búsqueda"   name="busqueda" type="text" >
                        </div-->
            
                        <div class="form-group  d-flex justify-content-start col-sm-4">
                            <input class="form-control mr-1 created_at flatpickr-input" placeholder="Selecciona rango de fechas" id="pc-daterangepicker-1" onchange="updateEndDate()" name="rango" type="text" readonly="readonly">
                        </div>
            
                        <div class=" col-sm-4">
                              <input type="submit" value="Filtrar">
                      </div>
            
                    </form>
                      <div class="btns-vertical-wrapper">
                        <div class="row">
                          <h3>USO DEL DEA</h3>

                            <div id="graficaUso">
                            </div>

                          <hr>
                          <h3>INSTALACIÓN DEL DEA</h3>

                            <div id="graficaInstalacion">
                            </div>
                          <hr>
                          <h3>USO DE EDAD PROMEDIO</h3>

                            <div id="graficaEdad">
                            </div>
                        </div></div>
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






<script src="<?php echo e(asset('vendor/apex-chart/apexcharts.min.js')); ?>"></script>
<script>


    $( document ).ready(function() {

        var data = []

        <?php $__currentLoopData = $lista; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            //console.log('<?php echo json_encode($item); ?>')
            var mes = '<?php echo $item["mes"]; ?>'

            data.push(mes);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        var data2 = []

        <?php $__currentLoopData = $lista2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            //console.log('<?php echo json_encode($item); ?>')
            var mes = '<?php echo $item["mes"]; ?>'
            var cant = '<?php echo $item["cantidad"]; ?>'

            data2.push({mes: mes, cantidad: cant});
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        var data3 = []

        <?php $__currentLoopData = $lista3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            //console.log('<?php echo json_encode($item); ?>')
            var edad = '<?php echo $item["edad"]; ?>'

            data3.push(edad);
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        //console.log(data3)

        const groups = data3.reduce((agg, curr)=>{
          if(agg[curr]){
            agg[curr] += 1
            }
          else{
            agg[curr] = 1
          }
          return agg
        },{})


      
     var options = {
          series: [{
          data: [
            data.filter((x) => x == "01").length,
            data.filter((x) => x == "02").length,
            data.filter((x) => x == "03").length,
            data.filter((x) => x == "04").length,
            data.filter((x) => x == "05").length,
            data.filter((x) => x == "06").length,
            data.filter((x) => x == "07").length,
            data.filter((x) => x == "08").length,
            data.filter((x) => x == "09").length,
            data.filter((x) => x == "10").length,
            data.filter((x) => x == "11").length,
            data.filter((x) => x == "12").length,
            ]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
            'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"
          ],
        }
        };

        var chart = new ApexCharts(document.querySelector("#graficaUso"), options);
        chart.render();



     var options2 = {
          series: [{
          data: [
            data2.filter((x) => x.mes == "01").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "02").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "03").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "04").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "05").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "06").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "07").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "08").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "09").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "10").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "11").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            data2.filter((x) => x.mes == "12").reduce((partialSum, a) => partialSum + +a.cantidad, 0),
            ]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
            'Agosto', 'Septiembre', 'Octubre', 'Noviembre', "Diciembre"
          ],
        }
        };

        var chart2 = new ApexCharts(document.querySelector("#graficaInstalacion"), options2);
        chart2.render();






        var options33 = {
          series: [{
          data: Object.values(groups)
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: Object.keys(groups),
        }
        };

        //var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
        //chart3.render();




        var options3 = {
          series: Object.values(groups),
          chart: {
          width: 550,
          type: 'pie',
        },
        labels: Object.keys(groups),
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 500
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
        };

        var chart3 = new ApexCharts(document.querySelector("#graficaEdad"), options3);
        chart3.render();

    });

</script>
<style>
  body {
    display: flex;
    width: 100% !important;
    height: auto !important;
    flex-direction: unset !important;
  }
</style>

<script>
        $(document).ready(function(){
            document.querySelector("#pc-daterangepicker-1").flatpickr({
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
         });
 </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/user-administrador/tableros-useradmin.blade.php ENDPATH**/ ?>