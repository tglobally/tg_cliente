<?php /** @var \tglobally\tg_cliente\controllers\controlador_com_producto $controlador */ ?>
<?php include 'templates/com_producto/alta/secciones.php'; ?>
<div class="col-md-9 formulario">
    <div class="col-lg-12">

        <h3 class="text-center titulo-form">Hola, <?php echo $controlador->datos_session_usuario['adm_usuario_user']; ?> </h3>

        <div class="  form-main" id="form">
            <form method="post" action="./index.php?seccion=com_producto&accion=alta_bd&session_id=<?php echo $controlador->session_id; ?>" class="form-additional">

                <?php echo $controlador->inputs->codigo; ?>
                <?php echo $controlador->inputs->codigo_bis; ?>
                <?php echo $controlador->inputs->descripcion; ?>
                <?php echo $controlador->inputs->obj_imp; ?>
                <?php echo $controlador->inputs->select->cat_sat_producto_id; ?>
                <?php echo $controlador->inputs->select->cat_sat_unidad_id; ?>
                <?php echo $controlador->inputs->select->cat_sat_obj_imp_id; ?>
                <?php echo $controlador->inputs->select->cat_sat_tipo_factor_id; ?>
                <?php echo $controlador->inputs->select->cat_sat_factor_id; ?>

                <div class="buttons col-md-12">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-info btn-guarda col-md-12 " name="btn_action_next" value="modifica">Guarda</button>
                    </div>
                    <div class="col-md-6 ">
                        <a href="index.php?seccion=com_producto&accion=lista&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info btn-guarda col-md-12 ">Regresar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
