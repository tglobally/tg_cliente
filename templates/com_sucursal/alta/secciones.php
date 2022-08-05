<?php use config\views; ?>

<div class="col-md-3 secciones">
    <div class="col-md-12 int_secciones ">
        <div class="col-md-4 seccion">
            <img src="<?php echo (new views())->url_assets.'img/stepper/2.svg'?>" class="img-seccion">
        </div>
        <div class="col-md-8">
            <h3>Alta Clientes</h3>
            <?php include "templates/com_cliente/_base/links/1.php"; ?>
            <hr class="hr-menu-lateral">
            <?php include "templates/com_sucursal/_base/buttons/6.azul.php"; ?>
        </div>
    </div>
</div>

