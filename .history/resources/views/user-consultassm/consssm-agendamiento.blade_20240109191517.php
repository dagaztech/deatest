@extends('layouts.main')
@section('title', __('Agendamiento'))


<div class="section-body">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card" >
                <div class="card" id="green-btn">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Agendamiento</h5>
                    </div>
                    <div class="card-body form-card-body">
                        <div class="row">
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="#" alt="Agendar Visita">Agendar Visita</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="#" alt="Ver Agenda">Ver Agenda</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="#" alt="Crear Acta de Visita">Crear Acta de Visita</a>
                             </div>
                             <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="green-btn">
                                <a href="#" alt="Ver Actas de Visita">Ver Actas de Visita</a>
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