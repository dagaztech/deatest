@extends('layouts.main')
@section('title', __('Evento en Curso EMER'))


<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card" >
                <div class="card" id="green-btn">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Evento en Curso EMER</h5>
                    </div>
                    <div class="card-body form-card-body">
                      
                        <div class="row">
                          <iframe src="/forms/survey/mJqAMrlNbWQWeyg5Kx2n" scrolling="auto" style="height:100vh;" width="100%"></iframe>
<br>
<div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="orange-btn">
  <a href="{{ route('user-operador1.formulario-infoevento') }}" alt="Información del Evento Cardiovascular">Información del Evento Cardiovascular</a>
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
