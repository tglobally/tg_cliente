<?php /** @var \tglobally\tg_cliente\controllers\controlador_tg_cte_alianza $controlador */ ?>

<?php include 'templates/tg_cte_alianza/asigna_cliente/secciones.php'; ?>
<div class="col-md-9 formulario">
    <div class="col-lg-12 row">

        <h3 class="text-center titulo-form">Hola, <?php echo $controlador->datos_session_usuario['adm_usuario_user']; ?> </h3>

        <div class="  form-main" id="form">
            <form method="post" action="./index.php?seccion=tg_cte_alianza&accion=rel_cliente_alianza_bd&session_id=<?php echo $controlador->session_id; ?>&registro_id=<?php echo $controlador->registro_id; ?>" class="form-additional">

                <?php echo $controlador->inputs->select->tg_cte_alianza_id; ?>
                <?php echo $controlador->inputs->select->com_cliente_id; ?>

                <div class="buttons col-md-12">
                    <div class="col-md-6 btn-ancho">
                        <button type="submit" class="btn btn-info btn-guarda col-md-12 " >Nueva</button>
                    </div>
                    <div class="col-md-6 btn-ancho">
                        <a href="index.php?seccion=tg_cte_alianza&accion=lista&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info btn-guarda col-md-12 ">Lista</a>
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
                <th>RFC</th>
                <th>Razon Social</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($controlador->com_clientes as $com_cliente){ ?>
                <tr>
                    <td><?php echo $com_cliente['com_cliente_id']; ?></td>
                    <td><?php echo $com_cliente['com_cliente_rfc']; ?></td>
                    <td><?php echo $com_cliente['com_cliente_razon_social']; ?></td>

                    <td>
                        <?php foreach ($com_cliente['acciones'] as $link){ ?>
                            <div class="col-md-3"><?php echo $link; ?></div>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>

        </table>
    </div>
</div>




