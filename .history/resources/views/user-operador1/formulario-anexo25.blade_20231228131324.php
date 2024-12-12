@extends('layouts.main')
@section('title', __('Personal Certificado en el Uso del DEA'))


<div class="section-body">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card" >
                <div class="card" id="green-btn">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Personal Certificado en el Uso del DEA</h5>
                    </div>
                    <div class="card-body form-card-body">
                      <button type="button" class="btn btn-primary open-info" data-toggle="modal" data-target="#exampleModalCenter">
 <img src="../../images/info.png" alt="Abrir modal">
</button>

                        <div class="row">
                          <iframe src="/forms/survey/M15wNJAPdRPLaGyOXpZK" scrolling="auto" style="height:100vh;" width="100%"></iframe>
<br>
<div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
  <a href="{{ route('user-operador1.formulario-anexo25') }}" alt="Agregar nuevo personal">Agregar nuevo personal</a>
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

