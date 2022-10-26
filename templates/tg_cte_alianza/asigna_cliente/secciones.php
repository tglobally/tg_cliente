<?php /** @var \tglobally\tg_cliente\controllers\controlador_tg_cte_alianza $controlador */?>
<?php use config\views; ?>

<div class="col-md-3 secciones">

    <div class="col-md-12 int_secciones ">
        <div class="col-md-4 seccion">
            <img src="<?php echo (new views())->url_assets.'img/stepper/1.svg'?>" class="img-seccion">
        </div>
        <div class="col-md-8">
            <h3>Alta Alianzas</h3>
            <?php include "templates/tg_cte_alianza/_base/buttons/1.gris.php"; ?>
            <hr class="hr-menu-lateral">
            <?php include "templates/tg_cte_alianza/_base/links/asigna_cliente.azul.php"; ?>
        </div>
    </div>
</div>

