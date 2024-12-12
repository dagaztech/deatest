@extends('layouts.main')
@section('title', __('Consulta de Registro de Equipos DEA'))


<div class="section-body">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Consulta de Registro de Equipos DEA</h5>
                    </div>
                    <div class="card-body form-card-body">
                      <div class="btns-vertical-wrapper"> 
                        <div class="row">
                            
                            <!--div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
                                <a href="#" alt="Consulta de Estado DEA">Consulta de Estado DEA</a>
                             </div-->

                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
                                <a href="/form-values/30/view" alt="Consulta de Instalación">Consulta de Instalación</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
                                <a href="{{ route('user-consultassm.informe-ubicaciondeas') }}" alt="Ubicación de Equipos DEA">Ubicación de Equipos DEA</a>
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