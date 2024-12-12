<!DOCTYPE html>
<html lang="es">

<head>
    <?php
        $primaryColor = \App\Facades\UtilityFacades::getsettings('color');
        if (isset($primaryColor)) {
            $color = $primaryColor;
        } else {
            $color = 'theme-2';
        }
    ?>
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(Utility::getsettings('app_name')); ?></title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Favicon icon -->
    <link rel="icon"
    href="<?php echo e(Utility::getsettings('favicon_logo') ? Storage::url('app-logo/app-favicon-logo.png') : ''); ?>"
    type="image/png">

    <?php if(Utility::getsettings('rtl') == '1'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <?php if(Utility::getsettings('dark_mode') == 'on'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>" id="main-style-link">
    <?php elseif(Utility::getsettings('rtl') != '1'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendor/css/custom.css')); ?>">
    <script>
        var toster_pos = 'right';
        window.addEventListener("load", function() {
            var loader = document.querySelector(".loading");
            $(loader).addClass('d-none');
        });
    </script> 
    <?php echo $__env->yieldPushContent('style'); ?>
</head>

<body class="<?php echo e($color); ?>">
    <div class="loading">Cargando…</div>
        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>
    <div class="dash-content">
        <?php echo $__env->yieldContent('content'); ?>
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
 
<script src="<?php echo e(secure_asset('vendor/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(secure_asset('assets/js/plugins/popper.min.js')); ?>"></script>
<script src="<?php echo e(secure_asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>"></script>
<script src="<?php echo e(secure_asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(secure_asset('assets/js/plugins/feather.min.js')); ?>"></script>
<script src="<?php echo e(secure_asset('vendor/modules/tooltip.js')); ?>"></script>
<script src="<?php echo e(secure_asset('vendor/ckeditor/ckeditor.js')); ?>"></script>
<script src="<?php echo e(secure_asset('assets/js/plugins/bouncer.min.js')); ?>"></script>
<script src="<?php echo e(secure_asset('assets/js/pages/form-validation.js')); ?>"></script>



<script src="<?php echo e(secure_asset('assets/js/plugins/sweetalert2.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap-notify.min.js')); ?>"></script>

    
    <script src="<?php echo e(secure_asset('assets/js/plugins/bootstrap-switch-button.min.js')); ?>"></script>

<script src="<?php echo e(secure_asset('assets/js/plugins/choices.min.js')); ?>"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.js" integrity="sha512-TrPFAh5wLxD2BZFrxjMNZwcS+K4wlgH1DLObvPh8rwxLgvj/fIPbSADLPds0RsiYoVV9cFT0Ve8R7G6zvrckiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->





<script src="<?php echo e(asset('vendor/js/custom.js')); ?>"></script>
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

<?php echo $__env->make('layouts.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldPushContent('script'); ?>
</body>

</html>
<?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/layouts/form.blade.php ENDPATH**/ ?>