<?php /** @var \tglobally\tg_cliente\controllers\controlador_com_sucursal $controlador */ ?>
<?php include 'templates/com_sucursal/asigna_empleado/secciones.php'; ?>
<div class="col-md-9 formulario">
    <div class="col-lg-12">

        <h3 class="text-center titulo-form">Hola, <?php echo $controlador->datos_session_usuario['adm_usuario_user']; ?> </h3>

        <div class="  form-main" id="form">
            <form method="post" action="./index.php?seccion=com_sucursal&accion=rel_empleado_sucursal_bd&session_id=<?php echo $controlador->session_id; ?>&registro_id=<?php echo $controlador->registro_id; ?>" class="form-additional">

                <?php echo $controlador->inputs->select->com_sucursal_id; ?>
                <?php echo $controlador->inputs->select->em_empleado_id; ?>

                <div class="buttons col-md-12">
                    <div class="col-md-6 btn-ancho">
                        <button type="submit" name="btn_action_next" value="asigna_empleado" class="btn btn-info btn-guarda col-md-12 " >Nueva</button>
                    </div>
                    <div class="col-md-6 btn-ancho">
                        <a href="index.php?seccion=com_sucursal&accion=lista&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info btn-guarda col-md-12 ">Lista</a>
                    </div>

                </div>
            </form>
        </div>
    </div>


    <div class="col-lg-12 row-12">
        <table id="em_empleado" class="table table-striped" >
            <thead>
            <tr>
                <th>Id</th>
                <th>Descripcion</th>
                <th>RFC</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($controlador->em_empleados as $em_empleado){ ?>
                <tr>
                    <td><?php echo $em_empleado['em_empleado_id']; ?></td>
                    <td><?php echo $em_empleado['em_empleado_descripcion']; ?></td>
                    <td><?php echo $em_empleado['em_empleado_rfc']; ?></td>

                    <td>
                        <?php foreach ($em_empleado['acciones'] as $link){ ?>
                            <div class="col-md-3"><?php echo $link; ?></div>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>
</div>




