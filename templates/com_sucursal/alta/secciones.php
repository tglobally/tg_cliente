<?php use config\views; ?>

<div class="col-md-3 secciones">
    <div class="col-md-12 int_secciones ">
        <div class="col-md-4 seccion">
            <img src="<?php echo (new views())->url_assets.'img/stepper/2.svg'?>" class="img-seccion">
        </div>
        <div class="col-md-8">
            <h3>Alta Sucursal</h3>
            <?php include "templates/com_sucursal/_base/buttons/1.azul.php"; ?>
            <hr class="hr-menu-lateral">
            <?php include "templates/com_sucursal/_base/buttons/2.gris.php"; ?>
        </div>
    </div>
</div>

