<?php /** @var \tglobally\tg_cliente\controllers\controlador_com_cliente $controlador */?>
<?php use config\views; ?>

<div class="col-md-3 secciones">

    <div class="col-md-12 int_secciones ">
        <div class="col-md-4 seccion">
            <img src="<?php echo (new views())->url_assets.'img/stepper/2.svg'?>" class="img-seccion">
        </div>
        <div class="col-md-8">
            <h3>Alta Sucursal</h3>
            <?php include "templates/com_cliente/_base/links/1.php"; ?>
            <hr class="hr-menu-lateral">
            <?php include "templates/com_cliente/_base/buttons/2.azul.php"; ?>
            <hr class="hr-menu-lateral">
            <?php include "templates/com_cliente/_base/links/3.php"; ?>
            <hr class="hr-menu-lateral">
            <?php include "templates/com_cliente/_base/links/4.php"; ?>
        </div>
    </div>
</div>

