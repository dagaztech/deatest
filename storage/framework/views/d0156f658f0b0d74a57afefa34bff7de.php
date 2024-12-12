<?php
    $user = \Auth::guard('api')->user();
    $primaryColor = $user->theme_color;
    if (isset($primaryColor) && $primaryColor != '') {
        $color = $primaryColor;
    } else {
        $color = 'theme-2';
    }

    $currantLang = $user->currentLanguage();
?>
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>"
    dir="<?php echo e(\App\Facades\UtilityFacades::getsettings('rtl') == '1' || $currantLang == 'ar'  ?  'rtl' : ''); ?>">

<head>

    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(Utility::getsettings('app_name')); ?></title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="title"
    content="<?php echo e(!empty(Utility::getsettings('meta_title'))
        ? Utility::getsettings('meta_title') :  Utility::getsettings('app_name')); ?>">
<meta name="keywords"
    content="<?php echo e(!empty(Utility::getsettings('meta_keywords'))
        ? Utility::getsettings('meta_keywords')
        : 'Multi Users,Role & permission , Form & poll management , document Genrator , Booking system'); ?>">
<meta name="description"
    content="<?php echo e(!empty(Utility::getsettings('meta_description'))
        ? Utility::getsettings('meta_description')
        : 'Discover the efficiency of prime-laravel, a user-friendly web application by Quebix Apps.'); ?>">
<meta name="meta_image_logo" property="og:image"
    content="<?php echo e(!empty(Utility::getsettings('meta_image_logo'))
        ? Storage::url(Utility::getsettings('meta_image_logo'))
        : Storage::url('seeder-image/meta-image-logo.jpg')); ?>">
    <?php if(Utility::getsettings('seo_setting') == 'on'): ?>
        <?php echo app('seotools')->generate(); ?>

    <?php endif; ?>
    <!-- Favicon icon -->
    <link rel="icon"
        href="<?php echo e(Utility::getsettings('favicon_logo') ? Storage::url('app-logo/app-favicon-logo.png') : ''); ?>"
        type="image/png">

    <!-- font css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/tabler-icons.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/feather.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/fontawesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/fonts/material.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendor/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/bootstrap-switch-button.min.css')); ?>">

    <!-- Bootstrap datetimepicker css -->
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/flatpickr.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/customizer.css')); ?>">

    <?php if($user->rtl_layout == 1 || $currantLang == 'ar'): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-rtl.css')); ?>" id="main-style-link">
    <?php endif; ?>
    <?php if($user->dark_layout == 1): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style-dark.css')); ?>" id="main-style-link">
    <?php elseif($user->rtl_layout == 0): ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>" id="main-style-link">
    <?php endif; ?>

    <link rel="stylesheet" href="<?php echo e(asset('vendor/css/custom.css')); ?>">
    <?php echo $__env->yieldPushContent('style'); ?>

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

    <script type="text/javascript">
        // Initialize the service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/public/serviceworker.js', {
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
</head>

<body class="<?php echo e($color); ?>">

    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Mobile header ] End -->
    <!-- [ navigation menu ] start -->
    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- [ navigation menu ] end -->
    <!-- [ Header ] start -->
    <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="dash-container">
        <div class="dash-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <?php echo $__env->yieldContent('breadcrumb'); ?>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <?php echo $__env->yieldContent('content'); ?>

            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
    <footer class="dash-footer">
        <div class="footer-wrapper">
            <div class="py-1">
                <span class="text-muted">&copy; <?php echo e(date('Y')); ?> <?php echo e(Utility::getsettings('app_name')); ?></span>
            </div>
            <div class="py-1">
            </div>
        </div>
    </footer>

    <div class="modal fade modal-animate anim-blur" role="dialog" id="common_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="body">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modal-animate anim-blur" role="dialog" id="common_modal1">
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
    <div class="modal fade modal-animate anim-blur" role="dialog" id="common_modal2">
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
    <div class="top-0 p-3 position-fixed end-0" style="z-index: 99999">
        <div id="liveToast" class="toast fade" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body"> </div>
                <button type="button" class="m-auto btn-close btn-close-white me-2" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('vendor/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/perfect-scrollbar.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/feather.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/modules/tooltip.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/js/dash.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/js/plugins/bouncer.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pages/form-validation.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/js/plugins/sweetalert2.all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap-notify.min.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap-switch-button.min.js')); ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        var toster_pos = 'right';
        function setLoading(ar){
                
            }
    </script>
    <script src="<?php echo e(asset('vendor/js/custom.js')); ?>"></script>

    <?php if(!empty(setting('gtag'))): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(setting('gtag')); ?>"></script>
        <script>


            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '<?php echo e(setting('gtag')); ?>');
        </script>
    <?php endif; ?>
    <script>
        feather.replace();
        var pctoggle = document.querySelector("#pct-toggler");
        if (pctoggle) {
            pctoggle.addEventListener("click", function() {
                if (
                    !document.querySelector(".pct-customizer").classList.contains("active")
                ) {
                    document.querySelector(".pct-customizer").classList.add("active");
                } else {
                    document.querySelector(".pct-customizer").classList.remove("active");
                }
            });
        }

        function removeClassByPrefix(node, prefix) {
            for (let i = 0; i < node.classList.length; i++) {
                let value = node.classList[i];
                if (value.startsWith(prefix)) {
                    node.classList.remove(value);
                }
            }
        }
        $(document).on("click", "#kt_activities_toggle", function() {
            $.ajax({
                url: '<?php echo e(route('read.notification')); ?>',
                data: {
                    _token: $("meta[name='csrf-token']").attr('content')
                },
                method: 'post',
            }).done(function(data) {
                if (data.is_success) {
                    $("#kt_activities_toggle").find(".animation-blink").remove();
                }
            });
        });
        $(document).ready(function() {
            $('.add_dark_mode').on('click', function() {
                var $this = $(this);
                $.ajax({
                    url: "<?php echo e(route('change.theme.mode')); ?>",
                    method: "POST",
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content'),
                    },
                    success: function(response) {
                        if (response.mode == 1) {
                            $this.find('i').removeClass('ti-sun').addClass('ti-moon');
                            $(".m-header > .b-brand > img").attr(
                                "src",
                                "<?php echo e(Storage::url(setting('app_logo')) ? Storage::url('app-logo/app-logo.png') : Storage::url('78x78.png')); ?>"
                            );
                            document.querySelector("#main-style-link").setAttribute("href",
                                "<?php echo e(asset('assets/css/style-dark.css')); ?>"
                            );
                        } else {
                            $this.find('i').removeClass('ti-moon').addClass('ti-sun');
                            document.querySelector(".m-header > .b-brand > img").setAttribute(
                                "src",
                                "<?php echo e(Storage::url(setting('app_dark_logo')) ? Storage::url('app-logo/app-dark-logo.png') : Storage::url('78x78.png')); ?>"
                            );
                            $(".m-header > .b-brand > img").attr(
                                "src",
                                response.app_dark_logo_url
                            );
                            document.querySelector("#main-style-link").setAttribute("href",
                                "<?php echo e(asset('assets/css/style.css')); ?>"
                            );
                        }
                    }
                });
            });
        });
    </script>
    <?php echo $__env->make('layouts.includes.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('script'); ?>
    <?php if(Utility::getsettings('cookie_setting_enable') == 'on'): ?>
        <?php echo $__env->make('layouts.cookie-consent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
</body>

</html>
<?php /**PATH C:\Users\andresmauriciogomezr\Documents\proyectos\dea-template-pwa\resources\views/layouts/main.blade.php ENDPATH**/ ?>