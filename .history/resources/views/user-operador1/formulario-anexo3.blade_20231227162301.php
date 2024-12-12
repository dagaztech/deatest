@extends('layouts.main')
@section('title', __('Formulario de reporte uso de Desfibrilador Externo Automático - DEA en ambiente extrahospitalario'))


<div class="section-body">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card" >
                <div class="card" id="green-btn">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Formulario de reporte uso de Desfibrilador Externo Automático - DEA en ambiente extrahospitalario</h5>
                           <small>(Ley 1831 del 12 de mayo de 2017)</small>
                    </div>
                    <div class="card-body form-card-body">
                      <button type="button" class="btn btn-primary open-info" data-toggle="modal" data-target="#exampleModalCenter">
 <img src="../../images/info.png" alt="Abrir modal">
</button>

                        <div class="row">
                            <!--Insertar Formulario-->

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

<!--INSERCION DEL MODAL-->
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">INSTRUCCIONES PARA DILIGENCIAR EL ANEXO TÉCNICO No. 3
</h5>
      </div>
      <div class="modal-body">

<p>INSTRUCCIONES PARA DILIGENCIAR EL ANEXO T&Eacute;CNICO No. 3</p>

<p>1. Fecha del evento: Escriba la fecha en la cual sucedi&oacute; el evento donde se utiliz&oacute; el DEA.</p>

<p>2. Nombre del lugar del evento: Escriba el nombre del lugar con alta afluencia de p&uacute;blico donde sucedi&oacute; el evento.</p>

<p>Datos de la persona atendida en el evento</p>

<p>3. Nombre completo: Escriba el nombre completo de la persona atendida con el uso del DEA;</p>

<p>4. Tipo de documento de identificaci&oacute;n: Escriba el tipo de documento de identificaci&oacute;n de la persona atendida con el uso del DEA;</p>

<p>5. N&uacute;mero de documento de identificaci&oacute;n: Escriba el n&uacute;mero de documento de identificaci&oacute;n de la persona atendida con el uso del DEA;</p>

<p>6. Edad: Escriba la edad en a&ntilde;os de la persona atendida con el uso del DEA;</p>

<p>7. Sexo: Marque con una X el sexo de la persona atendida con el uso del DEA;</p>

<p>8. Asegurador en Salud: Escriba el nombre de la aseguradora en salud a la cual se encuentra afiliada la persona atendida con el uso del DEA (entidades promotoras de salud, las entidades que administren planes voluntarios de salud, las entidades adaptadas de salud, las administradoras de riesgos profesionales en sus actividades de salud).</p>

<p>Datos del evento en donde se utiliz&oacute; el Desfibrilador Externo Autom&aacute;tico - DEA</p>

<p>Nombre de la persona que utiliz&oacute; el DEA: Escriba el nombre completo de la persona que utiliz&oacute; el DEA para realizar la descarga; Tipo de documento de identificaci&oacute;n: Escriba el n&uacute;mero del documento de identificaci&oacute;n de la persona que utiliz&oacute; el DEA para realizar la descarga; N&uacute;mero de documento de identificaci&oacute;n: Escriba el n&uacute;mero de documento de identificaci&oacute;n de la persona que utiliz&oacute; el DEA para realizar la descarga; Hora de inicio del evento: Escriba en n&uacute;meros la hora en la cual se inici&oacute; el eento en el cual se utiliz&oacute; el DEA; Hora de activaci&oacute;n de la cadena de supervivencia: Escriba en n&uacute;meros la hora en la cual se activ&oacute; la cadena de supervivencia del evento en el cual se utiliz&oacute; el DEA; Hora de utilizaci&oacute;n del DEA: Escriba en n&uacute;meros la hora en la cual se utiliz&oacute; el DEA; y Hora de traslado de la persona atendida a la instituci&oacute;n de salud: Escriba en n&uacute;meros la hora a la cual se realiz&oacute; el traslado de la persona atendida a la instituci&oacute;n de salud. En caso de fallecimiento de la persona en el lugar del evento, escriba N/A.</p>

<p>Datos del medio de transporte en el cual es trasladada la persona atendida a la instituci&oacute;n de salud</p>

<p>En caso de fallecimiento de la persona en el lugar del evento, no debe diligenciar las variables 17, 18 y 19.</p>

<p>Nombre de la persona ecargada del traslado: Escriba el nombre completo de la persona responsable de realizar el traslado a la instituci&oacute;n de salud establecida en la ruta; Medio de transporte utilizado para el traslado: Marque con una (X) el medio de transporte en el que se realiz&oacute; el traslado a la instituci&oacute;n de salud establecida en la ruta. Si la opci&oacute;n seleccionada es &ldquo;Otro&rdquo;, debe escribir cu&aacute;l fue el medio de transporte utilizado; Nombre de la empresa de la ambulancia: escriba el nombre de la empresa a la cual pertenece la ambulancia que realiz&oacute; el traslado; y. Observaciones: Escriba las observaciones que estime pertinentes, diferentes a los datos reportados en las variables anteriores.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>