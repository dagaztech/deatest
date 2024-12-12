@extends('layouts.main')
@section('title', __('Registro de instalación desfibriladores externos automáticos (DEA)'))

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
                           <a href="#inicio" class="top-menu-items" id="home-btn"> <!--{{ __('Previous') }}--></a>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mobile-login-btn  text-center">
                           <a href="#profile" class="top-menu-items" id="user-btn"> <!--{{ __('Profile') }}--></a>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="mobile-login-btn  text-center">
                           <a href="#logout" class="top-menu-items" id="logout-btn"> <!--{{ __('Logout') }}--></a>
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
                        <h5 class="text-center w-100" id="new-title">Registro de instalación desfibriladores externos automáticos (DEA)</h5>
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
        <h5 class="modal-title" id="exampleModalLongTitle">INSTRUCCIONES PARA DILIGENCIAR EL ANEXO TÉCNICO No. 2
</h5>
      </div>
      <div class="modal-body">

<p>INSTRUCCIONES PARA DILIGENCIAR EL ANEXO T&Eacute;CNICO No. 2</p>

<p>Ingresa el n&uacute;mero ID de formulario.</p>

<p>Responsable del lugar con alta afluencia del p&uacute;blico</p>

<p>1. Nombre completo: Escriba el nombre completo del responsable del lugar con alta afluencia del p&uacute;blico que registra el/los DEA.</p>

<p>2. Documento de identificaci&oacute;n: Escriba el n&uacute;mero del documento de identificaci&oacute;n del responsable del lugar con alta afluencia del p&uacute;blico que registra el/los DEA.</p>

<p>Datos del lugar con alta afluencia del p&uacute;blico.</p>

<p>3. Nombre: Escriba el nombre del lugar con alta afluencia de p&uacute;blico que registra la instalaci&oacute;n de el/los DEA .</p>

<p>4. Direcci&oacute;n: Escriba la direcci&oacute;n completa del lugar con alta afluencia de p&uacute;blico que registra la instalaci&oacute;n de(l)/los DEA.</p>

<p>5. C&oacute;digo postal: Escriba el c&oacute;digo postal del Iugar con alta afluencia de p&uacute;blico que registra la instalaci&oacute;n de(l)/los DEA.</p>

<p>6. Ciudad o municipio: Escriba el municipio donde est&aacute; ubicado el lugar con alta afluencia de p&uacute;blico que registra la instalaci&oacute;n de(l)/los DEA.</p>

<p>7. Departamento: Escriba el departamento donde est&aacute; ubicado el lugar con alta afluencia de p&uacute;blico que registra la instalaci&oacute;n de(l)/los DEA.</p>

<p>Declaraci&oacute;n</p>

<p>8. Se&ntilde;ale con una (X) la opci&oacute;n que corresponda:</p>

<p>a. Instalaci&oacute;n: se trata de la instalaci&oacute;n permanente o es temporal de(l)/los DEA. b. Cambio de titular: esta declaraci&oacute;n, se trata de un cambio del titular de(l)/los DEA. c. Retirada: esta declaraci&oacute;n, se trata de la retirada de(l)/los DEA. d. Modificaci&oacute;n de la ubicaci&oacute;n: esta declaraci&oacute;n, se trata de la modificaci&oacute;n de la ubicaci&oacute;n de(l)/los DEA. e. Otros; se&ntilde;ale si esta declaraci&oacute;n se trata de otro tipo.</p>

<p>Tipo de instalaci&oacute;n</p>

<p>Se&ntilde;ale con una (X) la opci&oacute;n que corresponda:</p>

<p>a. Obligatoria: si la instalaci&oacute;n de(l)/los DEA es obligatoria. b. Voluntaria: si la instalaci&oacute;n de(l)/los DEA corresponde a espacios no obligados a la dotaci&oacute;n de estos.</p>

<p>Tipo de espacio o lugar de alta afluencia de p&uacute;blico</p>

<p>Tipo de espacio: De conformidad con el presente acto administrativo indique el tipo de espacio o lugar con alta afluencia de personas.</p>

<p>Declaraci&oacute;n</p>

<p>8. Se&ntilde;ale con una (X) la opci&oacute;n que corresponda:</p>

<p>a. Instalaci&oacute;n: se trata de la instalaci&oacute;n permanente o es temporal de(l)/los DEA. b. Cambio de titular: esta declaraci&oacute;n, se trata de un cambio del titular de(l)/los DEA. c. Retirada: esta declaraci&oacute;n, se trata de la retirada de(l)/los DEA. d. Modificaci&oacute;n de la ubicaci&oacute;n: esta declaraci&oacute;n, se trata de la modificaci&oacute;n de la ubicaci&oacute;n de(l)/los DEA. e. Otros; se&ntilde;ale si esta declaraci&oacute;n se trata de otro tipo.</p>

<p>Tipo de instalaci&oacute;n</p>

<p>Se&ntilde;ale con una (X) la opci&oacute;n que corresponda:</p>

<p>a. Obligatoria: si la instalaci&oacute;n de(l)/los DEA es obligatoria. b. Voluntaria: si la instalaci&oacute;n de(l)/los DEA corresponde a espacios no obligados a la dotaci&oacute;n de estos.</p>

<p>Tipo de espacio o lugar de alta afluencia de p&uacute;blico</p>

<p>Tipo de espacio: De conformidad con el presente acto administrativo indique el tipo de espacio o lugar con alta afluencia de personas.</p>
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