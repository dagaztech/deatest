@php
$languages = \App\Facades\UtilityFacades::languages();
config([
'captcha.sitekey' => Utility::getsettings('recaptcha_key'),
'captcha.secret' => Utility::getsettings('recaptcha_secret'),
]);
@endphp
@extends('layouts.app')
@section('title', __('Iniciar sesión'))
@section('auth-topbar')
<li>
   <div class="alcaldia_menu_top">
      <div class="iconosmed_"><img src="images/alcaldiaFooter.png" width="35" height="35"/></div>
      <div class="dronwalcaldia_">
         <div class="titulalcaldia_">
            Alcaldía de Medellín
            <div class="drop">
               <p id="dropdownMenuLink">Secretarias y Dependencias</p>
               <div class="iconChevron" data-toggle="dropdown" onclick="myDisplayFunction()" ondblclick="myHideFunction()">
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                     <path fill="#ffffff" d="M233.4 406.6c12.5 12.5 32.8 12.5 45.3 0l192-192c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L256 338.7 86.6 169.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l192 192z"/>
                  </svg>
               </div>
            </div>
         </div>
         <div id="menualcaldias_lista">
            <div class="secre_depen_links">
               <div class="grid_">
                  <div class="listaditoscro">
                     <ul>
                        <div class="menu-secretarias-menu-container">
                           <ul id="menu-secretarias-menu" class="menu">
                              <li id="menu-item-23361" class="titulo_ente_ menu-item menu-item-type-custom menu-item-object-custom menu-item-23361"><a><b>Secretarías</b></a></li>
                              <li id="menu-item-21915" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21915"><a target="_blank" href="https://www.medellin.gov.co/es/dagrd/"><span id="HDepAdmGRD" title="Departamento Administrativo de Gestión del Riesgo y Desastres">Departamento Administrativo de Gestión del Riesgo de Desastres</span></a></li>
                              <li id="menu-item-16038" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16038"><a target="_blank" href="https://www.medellin.gov.co/es/departamento-administrativo-de-planeacion/"><span id="HDepAdmP" title="Departamento Administrativo de Planeación">Departamento Administrativo de Planeación</span></a></li>
                              <li id="menu-item-31644" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-31644"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-comunicaciones/"><span id="HSecComuni" title="Secretaría de Comunicaciones">Secretaría de Comunicaciones</span></a></li>
                              <li id="menu-item-8568" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8568"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-cultura-ciudadana/"><span id="HSecCC" title="Secretaría de Cultura Ciudadana">Secretaría de Cultura Ciudadana</span></a></li>
                              <li id="menu-item-15595" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15595"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-desarrollo-economico/"><span id="HSecDE" title="Secretaría de Desarrollo Económico">Secretaría de Desarrollo Económico</span></a></li>
                              <li id="menu-item-24492" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-24492"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-educacion/"><span id="HSecEdu" title="Secretaría de Educación">Secretaría de Educación</span></a></li>
                              <li id="menu-item-22526" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-22526"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-evaluacion-y-control/"><span id="HSecEvCo" title="Secretaría de Evaluación y Control">Secretaría de Evaluación y Control</span></a></li>
                              <li id="menu-item-11230" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11230"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-general/"><span id="HSecGen" title="Secretaría General">Secretaría General</span></a></li>
                              <li id="menu-item-15665" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15665"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-gestion-humana/"><span id="HSecGeHSC" title="Secretaría de Gestión Humana y Servicio a la Ciudadanía">Secretaría de Gestión Humana y Servicio a la Ciudadanía</span></a></li>
                              <li id="menu-item-23115" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23115"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-gestion-y-control-territorial/">Secretaría de Gestión y Control Territorial</a></li>
                              <li id="menu-item-12580" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12580"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-gobierno/"><span id="HSecGoGG" title="Secretaría de Gobierno y Gestión del Gabinete">Secretaría de Gobierno y Gestión del Gabinete</span></a></li>
                              <li id="menu-item-17720" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17720"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-hacienda/"><span id="HSecHa" title="Secretaría de Hacienda">Secretaría de Hacienda</span></a></li>
                              <li id="menu-item-22080" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-22080"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-inclusion/"><span id="HSecInSoFaDeHu">Secretaría de Inclusión Social, Familia y Derechos Humanos</span></a></li>
                              <li id="menu-item-12270" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12270"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-infraestructura-fisica/"><span id="HSecInfFi" title="Secretaría de Infraestructura Física">Secretaría de Infraestructura Física</span></a></li>
                              <li id="menu-item-31643" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-31643"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-innovacion-digital/">Secretaría de Innovación Digital</a></li>
                              <li id="menu-item-12853" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12853"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-juventud/"><span id="HSecJuv" title="Secretaría de La Juventud">Secretaría de La Juventud</span></a></li>
                              <li id="menu-item-19919" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-19919"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-la-no-violencia/"><span id="HSecNoViolencia" title="Secretaría de la No-Violencia">Secretaría de la No-Violencia</span></a></li>
                              <li id="menu-item-14813" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14813"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-mujeres/"><span id="HSecMuje" title="Secretaría de las Mujeres">Secretaría de las Mujeres</span></a></li>
                              <li id="menu-item-17342" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17342"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-medio-ambiente/"><span id="HSecMedAmb" title="Secretaría de Medio Ambiente">Secretaría de Medio Ambiente</span></a></li>
                              <li id="menu-item-21013" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21013"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-movilidad/"><span id="HSecMov" title="Secretaría de Movilidad">Secretaría de Movilidad</span></a></li>
                              <li id="menu-item-14948" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14948"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-participacion-ciudadana/"><span id="HSecPartCiu" title="Secretaría de Participación Ciudadana">Secretaría de Participación Ciudadana</span></a></li>
                              <li id="menu-item-12975" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-12975"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-privada/"><span id="HSecPriv" title="Secretaría Privada">Secretaría Privada</span></a></li>
                              <li id="menu-item-18587" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18587"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-de-salud/"><span id="HSecSalud" title="Secretaría de Salud">Secretaría de Salud</span></a></li>
                              <li id="menu-item-20782" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-20782"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-seguridad/"><span id="HSecSegConv" title="Secretaría de Seguridad y Convivencia">Secretaría de Seguridad y Convivencia</span></a></li>
                              <li id="menu-item-13211" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-13211"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-suministros-y-servicios/"><span id="HSecSumServ" title="Secretaría de Suministros y Servicios">Secretaría de Suministros y Servicios</span></a></li>
                              <li id="menu-item-23360" class="titulo_ente_ menu-item menu-item-type-custom menu-item-object-custom menu-item-23360"><a><b>Gerencias</b></a></li>
                              <li id="menu-item-14968" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-14968"><a target="_blank" href="https://www.medellin.gov.co/es/gerencia-del-centro/"><span id="HGerCentro" title="Gerencia del Centro">Gerencia del Centro</span></a></li>
                              <li id="menu-item-18597" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18597"><a target="_blank" href="https://www.medellin.gov.co/es/corregimientos/"><span id="HGerCorreg" title="Gerencia de Corregimientos">Gerencia de Corregimientos</span></a></li>
                              <li id="menu-item-23035" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-23035"><a target="_blank" href="https://www.medellin.gov.co/es/diversidades-sexualidades-e-identidad-de-genero/"><span id="HGerDivSexIdeGe" title="Gerencia de Diversidades Sexuales e Identidad de Género">Gerencia de Diversidades Sexuales e Identidad de Género</span></a></li>
                              <li id="menu-item-22957" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-22957"><a target="_blank" href="https://www.medellin.gov.co/es/gerencia-etnica/"><span id="HGerEtnica" title="Gerencia Étnica">Gerencia Étnica</span></a></li>
                              <li id="menu-item-13107" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-13107"><a target="_blank" href="https://www.medellin.gov.co/es/gerencia-de-proyectos-estrategicos/"><span id="HGerProyEstra" title="Gerencia de Proyectos Estratégicos">Gerencia de Proyectos Estratégicos</span></a></li>
                              <li id="menu-item-19380" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-19380"><a target="_blank" href="https://www.medellin.gov.co/es/unidad-administrativa-especial-buen-comienzo/"><span id="HUnidadAdmEspBuenCom" title="Unidad Administrativa Especial de Buen Comienzo">Unidad Administrativa Especial de Buen Comienzo</span></a></li>
                              <li id="menu-item-23359" class="titulo_ente_ menu-item menu-item-type-custom menu-item-object-custom menu-item-23359"><a><b>Despachos</b></a></li>
                              <li id="menu-item-50199" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-50199"><a target="_blank" href="https://www.medellin.gov.co/es/nuestro-alcalde/">Despacho del Alcalde</a></li>
                              <li id="menu-item-49972" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-49972"><a target="_blank" href="https://www.medellin.gov.co/es/despacho-de-la-gestora-social/">Despacho de la Gestora Social</a></li>
                              <li id="menu-item-191780" class="titulo_ente_ menu-item menu-item-type-custom menu-item-object-custom menu-item-191780"><a target="_blank" href="https://www.medellin.gov.co/es/secretaria-privada/conglomerado-publico/"><b>Conglomerado público</b></a></li>
                              <li id="menu-item-191779" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-191779"><a target="_blank" href="https://www.medellin.gov.co/infantil">Portal de niños</a></li>
                           </ul>
                        </div>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</li>
@endsection
@section('content')
<div class="login-page-wrapper">
   <div class="login-container">
      <div class="login-row d-flex">
         <div class="login-col-12">
            <div class="login-row d-flex">
               <img src="images/logo.png" class="delogo" alt="Medellín Me Cuida - SALUD" />
               <br>
               <h2 id="welcomed">¡Bienvenidos!</h2>
            </div>
         </div>
         <div class="login-row d-flex">
            <div class="login-content-inner ">
               <div class="login-title">
                  <h3>{{ __('Iniciar sesión') }}</h3>
               </div>
               {{ Form::open(['route' => ['login'], 'method' => 'POST', 'data-validate', 'class' => 'needs-validation']) }}
               <div class="mb-3 form-group">
                  {{ Form::label('email', __('Usuario'), ['class' => 'form-label mb-2']) }}
                  {!! Form::email('email', old('email'), [
                  'class' => 'form-control',
                  'id' => 'email',
                  'placeholder' => __('Ingresar correo electrónico'),
                  'onfocus',
                  'required',
                  ]) !!}
               </div>
               <div class="mb-3 form-group">
                  <div class="col-md-12">
                     {{ Form::label('password', __('Contraseña'), ['class' => 'form-label']) }}
                     {!! Html::link(route('password.request'), __('Recuperar contraseña ?'), ['class' => 'float-end forget-password']) !!}
                     {!! Form::password('password', [
                     'class' => 'form-control',
                     'placeholder' => __('Ingresar contraseña'),
                     'required',
                     'tabindex' => '2',
                     'id' => 'password',
                     'autocomplete' => 'current-password',
                     ]) !!}
                  </div>
               </div>
               @if (Utility::getsettings('login_recaptcha_status') == '1')
               <div class="my-3 text-center">
                  {!! NoCaptcha::renderJs() !!}
                  {!! NoCaptcha::display() !!}
               </div>
               @endif
               <div class="d-grid">
                  {!! Form::button(__('Ingresar'), ['type' => 'submit', 'class' => 'btn btn-primary btn-block mt-3']) !!}
               </div>
               {{ Form::close() }}
               <div class="register-option">
                  @if (Utility::getsettings('register') == 1)
                  <div class="create_user text-center ">
                     {{ __('¿No tiene cuenta?') }}
                     <a href="{{ route('register') }}">{{ __('Regístrese') }}</a>
                  </div>
                  @endif
               </div>
               <div class="social-media-icon">
                  @if (Utility::getsettings('GOOGLESETTING') == 'on' ||
                  Utility::getsettings('FACEBOOKSETTING') == 'on' ||
                  Utility::getsettings('GITHUBSETTING') == 'on')
                  <div class="mt-1 mb-4 row">
                     @if (Utility::getsettings('GOOGLESETTING') == 'on' ||
                     Utility::getsettings('FACEBOOKSETTING') == 'on' ||
                     Utility::getsettings('GITHUBSETTING') == 'on')
                     <p class="my-3 text-center register-link">{{ __('or register with') }}</p>
                     @endif
                     <div class="register-btn-wrapper">
                        @if (Utility::getsettings('GOOGLESETTING') == 'on')
                        <div class="col-4">
                           <div class="d-grid"><a href="{{ url('/redirect/google') }}"
                              class="btn btn-light">
                              {!! form::image(asset('assets/images/auth/img-google.svg'), null, ['class' => 'img-fluid wid-25']) !!}
                              </a>
                           </div>
                        </div>
                        @endif
                        @if (Utility::getsettings('FACEBOOKSETTING') == 'on')
                        <div class="col-4">
                           <div class="d-grid"><a href="{{ url('/redirect/facebook') }}"
                              class="btn btn-light">
                              {!! form::image(asset('assets/images/auth/img-facebook.svg'), null, ['class' => 'img-fluid wid-25']) !!}
                              </a>
                           </div>
                        </div>
                        @endif
                        @if (Utility::getsettings('GITHUBSETTING') == 'on')
                        <div class="col-4">
                           <div class="d-grid"><a href="{{ url('/redirect/github') }}"
                              class="btn btn-light">
                              {!! form::image(asset('assets/images/auth/github.svg'), null, ['class' => 'img-fluid wid-25']) !!}
                              </a>
                           </div>
                        </div>
                        @endif
                     </div>
                  </div>
                  @endif
               </div>
            </div>
         </div>
         
      </div>
   </div>
</div>
@endsection
@push('script')
<script>
   function myDisplayFunction() {
     document.getElementById("menualcaldias_lista").style.display = "block";
   }
   function myHideFunction() {
     document.getElementById("menualcaldias_lista").style.display = "none";
   }
</script>
@endpush