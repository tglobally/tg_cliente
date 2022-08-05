<?php /** @var \tglobally\tg_cliente\controllers\controlador_com_cliente $controlador */ ?>
<?php use config\views;
$url_icons = (new views())->url_icons;
?>

<?php include 'templates/com_cliente/lista/secciones.php'; ?>

<div class="col-md-9 info-lista">
    <div class="col-lg-12 content">
        <h3 class="text-center titulo-form">Hola, <?php echo $controlador->datos_session_usuario['adm_usuario_user']; ?></h3>

        <div class="col-md-12 mt-3 table-responsive-sm">

            <div class="filters">
                <div class="filter col-md-4 acciones_filter">
                    <a class="icon_xls_lista">
                        <img src="<?php echo $url_icons; ?>icon_xls.png">
                    </a>
                    <a class="icon_atras_lista">
                        <img src="<?php echo $url_icons; ?>icon_pag_atras.svg">
                    </a>
                    <p class="paginador">3 de 35</p>
                    <a class="icon_adelante_lista">
                        <img src="<?php echo $url_icons; ?>icon_pag_adelante.svg">
                    </a>
                </div>
                <div class="search col-md-8 input_search">
                    <input type="text form-control input">
                    <img class="input_icon" src="<?php echo $url_icons; ?>icon_lupa.svg">
                </div>
            </div>

            <table class="table table-dark">
                <thead>
                <tr>
                    <th scope="col">Acciones</th>
                    <th scope="col">Id</th>
                    <th scope="col">RFC</th>
                    <th scope="col">Razon Social</th>
                    <th scope="col">Nombre comercial</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th class="colum_accion" scope="row">
                        <a class="icon_modifica_lista">
                            <img src="<?php echo $url_icons; ?>icon_modifica.svg">
                        </a>
                        <a class="icon_elimina_lista">
                            <img src="<?php echo $url_icons; ?>icon_elimina.svg">
                        </a>
                        <a class="icon_descargar_lista">
                            <img src="<?php echo $url_icons; ?>icon_descargar.svg">
                        </a>
                    </th>
                    <th>1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                </tr>
                <tr>
                    <th class="colum_accion" scope="row">
                        <a class="icon_modifica_lista">
                            <img src="<?php echo $url_icons; ?>icon_modifica.svg">
                        </a>
                        <a class="icon_elimina_lista">
                            <img src="<?php echo $url_icons; ?>icon_elimina.svg">
                        </a>
                        <a class="icon_descargar_lista">
                            <img src="<?php echo $url_icons; ?>icon_descargar.svg">
                        </a>
                    </th>
                    <th>2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
