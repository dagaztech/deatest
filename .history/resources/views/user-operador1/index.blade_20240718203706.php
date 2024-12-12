@extends('layouts.main')
@section('title', __('Registro y gestión de espacios o lugares'))


<div class="section-body normal-width">
    <div class="mx-0 mt-5 row">
        <div class="mx-auto col-md-12 rounded-card">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center w-100" id="new-title">Bienvenido Operador</h5>
                    </div>
                    <div class="card-body form-card-body">
                      <div class="btns-vertical-wrapper">
                        <div class="row">
                            <div class="col-md-6 mx-auto btn-navigate btn-primary btn-block mt-3" id="orange-btn">
                                <a href="/forms/survey/mJqAMrlNbWQWeyg5Kx2n" alt="Activar Ruta Vital">Activar Ruta Vital</a>
                             </div>
                             <div class="clear"></div>
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="purple-btn">
                               <a href="{{ route('user-operador1.opciones-formulario') }}" alt="Anexo 2. Reporte de instalación del Desfibrilador Externo Automático (DEA). Formulario Dinámico.">Anexo 2. Reporte de instalación del Desfibrilador Externo Automático (DEA). Formulario Dinámico. </a>
                            </div>
                            <div class="col-md-6 btn-navigate btn-primary btn-block mt-3" id="orange-btn">
                                <a href="{{ route('user-operador1.menu-anexo3') }}" alt="Anexo 3. Reporte del uso del Desfibrilador Externo Automático (DEA). Formulario Dinámico.">Anexo 3. Reporte del uso del Desfibrilador Externo Automático (DEA). Formulario Dinámico.</a>
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