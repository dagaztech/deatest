<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ \App\Facades\UtilityFacades::getsettings('rtl') == '1' ? 'rtl' : '' }}">

<head>
    @php
        $primaryColor = \App\Facades\UtilityFacades::getsettings('color');
        if (isset($primaryColor)) {
            $color = $primaryColor;
        } else {
            $color = 'theme-2';
        }
    @endphp
    <title>@yield('title') | {{ Utility::getsettings('app_name') }}</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon"
    href="{{ Utility::getsettings('favicon_logo') ? Storage::url('app-logo/app-favicon-logo.png') : '' }}"
    type="image/png">

    @if (Utility::getsettings('rtl') == '1')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif
    @if (Utility::getsettings('dark_mode') == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}" id="main-style-link">
    @elseif(Utility::getsettings('rtl') != '1')
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif
    <link rel="stylesheet" href="{{ asset('vendor/css/custom.css') }}">

    @stack('style')
</head>

<body class="{{ $color }}">
    <div class="loading">Cargando…</div>
    <script>
        var toster_pos = 'right';
        window.addEventListener("load", function() {
            var loader = document.querySelector(".loading");
            $(loader).addClass('d-none');
        });
    </script> 
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
    <div class="dash-content">
        @yield('content')
    </div>
    <div class="modal fade" role="dialog" id="common_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" id="common_modal1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar">
                    </button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="top-0 p-3 position-fixed end-0" style="z-index: 99999">
        <div id="liveToast" class="toast fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"> </div>
                <button type="button" class="m-auto btn-close btn-close-white me-2" data-bs-dismiss="toast"
                    aria-label="Cerrar"></button>
            </div>
        </div>
    </div>
</body>
 
<script src="{{ secure_asset('vendor/js/jquery.min.js') }}"></script>
<script src="{{ secure_asset('assets/js/plugins/popper.min.js') }}"></script>
<script src="{{ secure_asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ secure_asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ secure_asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ secure_asset('vendor/modules/tooltip.js') }}"></script>
<script src="{{ secure_asset('vendor/ckeditor/ckeditor.js') }}"></script>
<script src="{{ secure_asset('assets/js/plugins/bouncer.min.js') }}"></script>
<script src="{{ secure_asset('assets/js/pages/form-validation.js') }}"></script>



<script src="{{ secure_asset('assets/js/plugins/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-notify.min.js') }}"></script>

    {{-- toogle button landing page  && backend settings  --}}
    <script src="{{ secure_asset('assets/js/plugins/bootstrap-switch-button.min.js') }}"></script>

<script src="{{ secure_asset('assets/js/plugins/choices.min.js') }}"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.js" integrity="sha512-TrPFAh5wLxD2BZFrxjMNZwcS+K4wlgH1DLObvPh8rwxLgvj/fIPbSADLPds0RsiYoVV9cFT0Ve8R7G6zvrckiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->





<script src="{{ asset('vendor/js/custom.js') }}"></script>
<script>
    feather.replace();
</script>

<script>
    feather.replace();
    var multipleCancelButton = new Choices('#sschoices-multiple-remove-button', {
        removeItemButton: true,
    });
</script>

<script>
// $(function() {
//   // Handler for .ready() called.
// var o, i;
//     icon = "fas fa-times-circle";
//         cls = "danger";
// $.notify({
//         icon: icon,
//         title: " " + "title",
//         message: "message",
//         url: ""
//     }, {
//         element: "body",
//         type: cls,
//         allow_dismiss: !0,
//         placement: {
//             from: 'top',
//             align: toster_pos
//         },
//         offset: {
//             x: 15,
//             y: 15
//         },
//         spacing: 10,
//         z_index: 1080,
//         delay: 2500,
//         timer: 2000,
//         url_target: "_blank",
//         mouse_over: !1,
//         animate: {
//             enter: o,
//             exit: i
//         },
//         template: '<div class="toast text-white bg-' + cls + ' fade show" role="alert" aria-live="assertive" aria-atomic="true">' +
//             '<div class="d-flex">' +
//             '<div class="toast-body"> ' + "message" + ' </div>' +
//             '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
//             '</div>' +
//             '</div>'
//     });
// });

</script>

@include('layouts.includes.alerts')
@stack('script')
</body>

</html>
