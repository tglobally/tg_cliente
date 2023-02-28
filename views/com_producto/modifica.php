<?php /** @var \tglobally\tg_cliente\controllers\controlador_com_producto $controlador */ ?>

<?php include 'templates/com_producto/modifica/secciones.php'; ?>
<div class="col-md-9 formulario">
    <div class="col-lg-12">

        <h3 class="text-center titulo-form">Hola, <?php echo $controlador->datos_session_usuario['adm_usuario_user']; ?> </h3>

        <div class="  form-main" id="form">
            <form method="post" action="./index.php?seccion=com_producto&accion=modifica_bd&session_id=<?php echo $controlador->session_id; ?>&registro_id=<?php echo $controlador->registro_id; ?>" class="form-additional">
                <?php echo $controlador->inputs->cat_sat_tipo_producto_id; ?>
                <?php echo $controlador->inputs->cat_sat_division_producto_id; ?>
                <?php echo $controlador->inputs->cat_sat_grupo_producto_id; ?>
                <?php echo $controlador->inputs->cat_sat_clase_producto_id; ?>
                <?php echo $controlador->inputs->cat_sat_producto_id; ?>
                <?php echo $controlador->inputs->codigo; ?>
                <?php echo $controlador->inputs->com_tipo_producto_id; ?>
                <?php echo $controlador->inputs->descripcion; ?>
                <?php echo $controlador->inputs->cat_sat_unidad_id; ?>
                <?php echo $controlador->inputs->cat_sat_obj_imp_id; ?>

                <div class="buttons col-md-12">
                    <div class="col-md-6 btn-ancho">
                        <button type="submit" class="btn btn-info btn-guarda col-md-12 " >Modifica</button>
                    </div>
                    <div class="col-md-6 btn-ancho">
                        <a href="index.php?seccion=com_producto&accion=lista&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info btn-guarda col-md-12 ">Lista</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

