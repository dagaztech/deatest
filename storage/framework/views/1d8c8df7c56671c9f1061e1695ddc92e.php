<?php $__env->startPush('script'); ?>
    <script src="<?php echo e(asset('vendor/js/webcam.min.js')); ?>"></script>
    <script language="JavaScript">
        Webcam.set({
            width: 300,
            height: 250,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            });
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\andresmauriciogomezr\Documents\proyectos\dea-template-pwa\resources\views/form/js/selfie.blade.php ENDPATH**/ ?>