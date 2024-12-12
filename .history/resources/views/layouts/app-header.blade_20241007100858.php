@php
    $users = \Auth::user();
    $languages = Utility::languages();
    $profile = asset(Storage::url('avatar/'));
@endphp
<!DOCTYPE html>
<html lang="es">

<head>
    <!--title>@yield('title') | {{ Utility::getsettings('app_name') }}</title-->
    <title>PWA Desfribiladores</title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="title"
    content="{{ !empty(Utility::getsettings('meta_title'))
        ? Utility::getsettings('meta_title') :  Utility::getsettings('app_name')  }}">
<meta name="keywords"
    content="{{ !empty(Utility::getsettings('meta_keywords'))
        ? Utility::getsettings('meta_keywords')
        : 'Alcaldia de Medellín, Secretaria de Salud de Medellin, App Progresiva de Desfibriladores' }}">
<meta name="description"
    content="{{ !empty(Utility::getsettings('meta_description'))
        ? Utility::getsettings('meta_description')
        : 'App Progresiva de Desfibriladores' }}">
<meta name="meta_image_logo" property="og:image"
    content="{{ !empty(Utility::getsettings('meta_image_logo'))
        ? Storage::url(Utility::getsettings('meta_image_logo'))
        : Storage::url('seeder-image/meta-image-logo.jpg') }}">
    @if (Utility::getsettings('seo_setting') == 'on')
        {!! app('seotools')->generate() !!}
    @endif
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images/icon-192x192.png') }}" type="image/png">
    <link rel="icon" href="../../public/images/icon-192x192.png" type="image/png">
    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/landingpage-2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/landing-page2/css/landingpage2-responsive.css') }}">

    <!-- Web Application Manifest -->
    <link rel="manifest" href="/manifest.json">
    <!-- Chrome for Android theme color -->
    <meta name="theme-color" content="#000000">

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="PWA">
    <link rel="icon" sizes="512x512" href="/images/icons/icon-512x512.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="PWA">
    <link rel="apple-touch-icon" href="/images/icons/icon-512x512.png">

    <link href="/images/icons/splash-640x1136.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-750x1334.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1242x2208.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1125x2436.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-828x1792.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1242x2688.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1536x2048.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1668x2224.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-1668x2388.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
    <link href="/images/icons/splash-2048x2732.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

    <!-- Tile for Win8 -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/images/icons/icon-512x512.png">
    <script>
        var toster_pos = 'right';
        window.addEventListener("load", function() {
            var loader = document.querySelector(".loading");
            $(loader).addClass('d-none');
        });
    </script> 
    <script type="text/javascript">
        // Initialize the service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/serviceworker.js', {
                scope: '/public/'
            }).then(function (registration) {
                // Registration was successful
                console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
            }, function (err) {
                // registration failed :(
                console.log('Laravel PWA: ServiceWorker registration failed: ', err);
            });
        }
    </script>
<script>
    function checkSession() {
        fetch('/check-session')
            .then(response => response.json())
            .then(data => {
                if (!data.authenticated) {
                    window.location.href = 'https://dea.wearesmart.co/login';
                }
            })
            .catch(error => {
                console.error('Error al verificar la sesión:', error);
            });
    }
 
    // Verificar la sesión al cargar la página
    window.onload = checkSession;
 
    // Opcional: Verificar la sesión periódicamente
    setInterval(checkSession, 60000); // cada 60 segundos
 </script>
 <script>
    // Función para añadir el manejo de cierre de sesión a los enlaces
    function addLogoutHandler() {
        document.querySelectorAll('a[href="https://dea.wearesmart.co/logout"]').forEach(anchor => {
            anchor.addEventListener('click', function(event) {
                event.preventDefault(); // Evitar la navegación predeterminada
                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (response.ok) {
                        window.location.href = 'https://dea.wearesmart.co/login';
                    }
                })
                .catch(error => {
                    console.error('Error al cerrar la sesión:', error);
                });
            });
        });
    }
 
    // Función para redirigir a la página de login si la URL actual es "/logout"
    function redirectIfLogoutUrl() {
        if (window.location.pathname === 'https://dea.wearesmart.co/logout') {
            window.location.href = 'https://dea.wearesmart.co/login';
        }
    }
 
    // Llamar a las funciones al cargar la página
    window.onload = function() {
        addLogoutHandler();
        redirectIfLogoutUrl();
    };
 </script>
</head>

<body class="light">
    <div class="loading">Cargando…</div>

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <header class="site-header header-style-one">
        <div class="main-navigationbar">
            <div class="container">
                <div class="navigation-row d-flex align-items-center ">
                    <nav class="menu-items-col d-flex align-items-center justify-content-between ">
                        <div class="logo-col">
                            <h1>
                                <a href="{{ route('landingpage') }}" tabindex="0">
                                    <img src="{{ asset('images/logo.png') }}"
                                    class="mainlogo" />
                                </a>
                            </h1>
                        </div>
                        <div class="menu-item-right-col d-flex align-items-center justify-content-between">
                          
                            <div class="menu-right-col">
                                <ul class=" d-flex align-items-center">
                                    
                                    @yield('auth-topbar')

                                    <li class="mobile-menu">
                                        <button class="mobile-menu-button" id="menu">
                                            <div class="one"></div>
                                            <div class="two"></div>
                                            <div class="three"></div>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="mobile-menu-wrapper">
                <div class="mobile-menu-bar">
                    <ul>
                        <li><a href="{{ route('landingpage') }}" tabindex="0">{{ __('Inicio') }}</a></li>
                        @php
                            $headerMainMenus = App\Models\HeaderSetting::get();
                        @endphp
                        @if (!empty($headerMainMenus))
                            @foreach ($headerMainMenus as $headerMainMenu)
                                <li class="menu-has-items">
                                    @php
                                        $page = App\Models\PageSetting::find($headerMainMenu->page_id);
                                    @endphp
                                    <a @if ($page->type == 'link') ?  href="{{ $page->page_url }}"  @else  href="{{ route('description.page', $headerMainMenu->slug) }}" @endif
                                        tabindex="0">
                                        {{ $page->title }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        <li>
                            <div class="mobile-login-btn">
                                <a href="{{ route('login') }}"> {{ __('Ingresar') }}</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!--PARA TRADUCIR BOTONES DE SUBMIT Y SIMILARES-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Selecciona todos los botones en la página
        const botones = document.querySelectorAll("button");
    
        // Diccionario de traducciones
        const traducciones = {
            "Next": "Siguiente",
            "Previous": "Anterior",
            "Submit": "Enviar",
            "Clear": "Limpiar",
            "Claro": "Limpiar"
        };
    
        // Recorre cada botón y verifica si su texto está en inglés
        botones.forEach(function(boton) {
            const textoBoton = boton.textContent.trim();
            
            // Si el texto del botón está en el diccionario, lo traduce
            if (traducciones[textoBoton]) {
                boton.textContent = traducciones[textoBoton];
            }
        });
    });
    </script>