<?php use config\views; ?>

<div class="col-md-3 secciones">
    <div class="col-md-12 int_secciones ">
        <div class="col-md-4 seccion">
            <img src="<?php echo (new views())->url_assets.'img/stepper/1.svg'?>" class="img-seccion">
        </div>
        <div class="col-md-8">
            <h3>Alta Clientes</h3>
            <?php include "templates/com_cliente/_base/buttons/1.azul.php"; ?>
            <hr class="hr-menu-lateral">
            <?php include "templates/com_cliente/_base/buttons/2.gris.php"; ?>
            <hr class="hr-menu-lateral">
            <?php include "templates/com_cliente/_base/buttons/3.gris.php"; ?>
            <hr class="hr-menu-lateral">
            <?php include "templates/com_cliente/_base/buttons/4.gris.php"; ?>
        </div>
    </div>
</div>


