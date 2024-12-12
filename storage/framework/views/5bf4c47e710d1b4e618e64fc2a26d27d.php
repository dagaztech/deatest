<?php
    $hashids = new Hashids('', 20);
    $id = $hashids->encodeHex($form->id);
?>
<div class="row">
    <div class="text-center">
        <?php echo QrCode::size(200)->generate(route('forms.survey', $id)); ?>

    </div>
</div>
<?php /**PATH /home/ubuntu/dea-template-pwa/resources/views/form/public-fill-qr.blade.php ENDPATH**/ ?>