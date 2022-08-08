<?php /** @var \tglobally\tg_cliente\controllers\controlador_tg_sucursal_alianza $controlador */ ?>
<?php include 'templates/tg_sucursal_alianza/alta/secciones.php'; ?>
<div class="col-md-9 formulario">
    <div class="col-lg-12">

        <h3 class="text-center titulo-form">Hola, <?php echo $controlador->datos_session_usuario['adm_usuario_user']; ?> </h3>

        <div class="  form-main" id="form">
            <form method="post" action="./index.php?seccion=tg_sucursal_alianza&accion=alta_bd&session_id=<?php echo $controlador->session_id; ?>" class="form-additional">

                <?php echo $controlador->inputs->codigo; ?>
                <?php echo $controlador->inputs->codigo_bis; ?>
                <?php echo $controlador->inputs->descripcion; ?>
                <?php echo $controlador->inputs->select->com_sucursal_id; ?>
                <?php echo $controlador->inputs->select->tg_cte_alianza_id; ?>


                <div class="buttons col-md-12">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-info btn-guarda col-md-12 " name="btn_action_next" value="modifica">Guarda</button>
                    </div>
                    <div class="col-md-6 ">
                        <a class="btn btn-info btn-guarda col-md-12 ">Siguiente</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
