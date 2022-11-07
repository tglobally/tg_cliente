<?php /** @var \tglobally\tg_cliente\controllers\controlador_com_cliente $controlador */ ?>

<?php include 'templates/com_cliente/rel_empleado_sucursal/secciones.php'; ?>
<div class="col-md-9 formulario">
    <div class="col-lg-12 row">

        <h3 class="text-center titulo-form">Hola, <?php echo $controlador->datos_session_usuario['adm_usuario_user']; ?> </h3>

        <div class="  form-main" id="form">
            <form method="post" action="./index.php?seccion=com_cliente&accion=rel_empleado_sucursal_bd&session_id=<?php echo $controlador->session_id; ?>&registro_id=<?php echo $controlador->registro_id; ?>" class="form-additional">

                <?php echo $controlador->inputs->select->com_cliente_id; ?>
                <?php echo $controlador->inputs->select->com_sucursal_id; ?>
                <?php echo $controlador->inputs->select->em_empleado_id; ?>

                <div class="buttons col-md-12">
                    <div class="col-md-6 btn-ancho">
                        <button type="submit" class="btn btn-info btn-guarda col-md-12">Nueva</button>
                    </div>
                    <div class="col-md-6 btn-ancho">
                        <a href="index.php?seccion=com_cliente&accion=lista&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info btn-guarda col-md-12 ">Lista</a>
                    </div>

                </div>
            </form>
        </div>
    </div>


    <div class="col-lg-12 row-12">
        <table id="com_cliente" class="table table-striped" >
            <thead>
            <tr>
                <th>Id</th>
                <th>Codigo</th>
                <th>Descripcion</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($controlador->tg_cte_alianzas as $tg_cte_alianza){ ?>
                <tr>
                    <td><?php echo $tg_cte_alianza['tg_cte_alianza_id']; ?></td>
                    <td><?php echo $tg_cte_alianza['tg_cte_alianza_codigo']; ?></td>
                    <td><?php echo $tg_cte_alianza['tg_cte_alianza_descripcion']; ?></td>

                    <td>
                        <?php foreach ($tg_cte_alianza['acciones'] as $link){ ?>
                            <div class="col-md-3"><?php echo $link; ?></div>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>
</div>




