<?php /** @var \tglobally\tg_cliente\controllers\controlador_com_cliente $controlador */ ?>
<?php include 'templates/com_cliente/alta/secciones.php'; ?>
<div class="col-md-9 formulario">
    <div class="col-lg-12">

        <h3 class="text-center titulo-form">Hola, <?php echo $controlador->datos_session_usuario['adm_usuario_user']; ?> </h3>

        <div class="  form-main" id="form">
            <form method="post" action="./index.php?seccion=com_cliente&accion=alta_bd&session_id=<?php echo $controlador->session_id; ?>" class="form-additional">

                <?php echo $controlador->inputs->codigo; ?>
                <?php echo $controlador->inputs->codigo_bis; ?>
                <?php echo $controlador->inputs->rfc; ?>
                <?php echo $controlador->inputs->descripcion; ?>
                <?php echo $controlador->inputs->razon_social; ?>
                <?php echo $controlador->inputs->select->cat_sat_regimen_fiscal_id; ?>
                <?php echo $controlador->inputs->select->dp_pais_id; ?>
                <?php echo $controlador->inputs->select->dp_estado_id; ?>
                <?php echo $controlador->inputs->select->dp_municipio_id; ?>
                <?php echo $controlador->inputs->select->dp_cp_id; ?>
                <?php echo $controlador->inputs->select->dp_colonia_id; ?>
                <?php echo $controlador->inputs->select->dp_calle_pertenece_id; ?>
                <?php echo $controlador->inputs->select->cat_sat_uso_cfdi_id; ?>
                <?php echo $controlador->inputs->select->cat_sat_moneda_id; ?>
                <?php echo $controlador->inputs->select->cat_sat_tipo_de_comprobante_id; ?>
                <?php echo $controlador->inputs->select->cat_sat_forma_pago_id; ?>
                <?php echo $controlador->inputs->select->cat_sat_metodo_pago_id; ?>
                <?php echo $controlador->inputs->numero_interior; ?>
                <?php echo $controlador->inputs->numero_exterior; ?>
                <?php echo $controlador->inputs->telefono; ?>

                <div class="buttons col-md-12">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-info btn-guarda col-md-12 " name="btn_action_next" value="modifica">Guarda</button>
                    </div>
                    <div class="col-md-6 ">
                        <a href="index.php?seccion=com_cliente&accion=lista&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info btn-guarda col-md-12 ">Regresar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
