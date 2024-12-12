@extends('layouts.main')
@section('title', __('Consulta Entidad'))


<div class="section-body">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Consultas de Entidad</h5>
                    </div>
                    <div class="card-body form-card-body">
                      <div class="btns-vertical-wrapper"> 
                        <div class="row">
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
                               <a href="/form-values/11/view" alt="Consulta de instalación">Consulta de instalación</a>
                            </div>
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="orange-btn">
                                <a href="/form-values/14/view" alt="Consulta de Uso de los DEA">Consulta de Uso de los DEA</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="{{ route('user-administrador.gestion-informacion') }}" alt="Consulta de reportes">Consulta de reportes</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
                                <a href="{{ route('user-administrador.reportes-useradmin') }}" alt="Visualización de tableros">Visualización de tableros </a>
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