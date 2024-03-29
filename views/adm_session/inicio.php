<?php /** @var tglobally\tg_cliente\controllers\controlador_adm_session $controlador */

use config\views;
$url_assets = (new views())->url_assets;
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="cont_text_inicio">
                <h1 class="h-side-title page-title page-title-big text-color-primary">Hola, <?php echo $controlador->datos_session_usuario['adm_usuario_user']; ?></h1>
                <h1 class="h-side-title page-title text-color-primary">Da click en la sección que deseas utilizar</h1>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-2">
                <a href="<?php echo $controlador->link_lista_tg_cte_tipo_alianza; ?>">
                    <div class="cont_imagen_accion">
                        <img src="<?php echo $url_assets; ?>img/inicio/imagen_2.jpg">
                    </div>
                    <div class="cont_text_accion">
                        <h4 class="text_seccion">Tipos de Alianza</h4>
                        <h4 class="text_accion">Catologo</h4>
                    </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo $controlador->link_lista_tg_cte_alianza; ?>">
                    <div class="cont_imagen_accion">
                        <img src="<?php echo $url_assets; ?>img/inicio/imagen_2.jpg">
                    </div>
                    <div class="cont_text_accion">
                        <h4 class="text_seccion">Alianzas</h4>
                        <h4 class="text_accion">Catologo</h4>
                    </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo $controlador->link_lista_com_cliente; ?>">
                    <div class="cont_imagen_accion">
                        <img src="<?php echo $url_assets; ?>img/inicio/imagen_2.jpg">
                    </div>
                    <div class="cont_text_accion">
                        <h4 class="text_seccion">Clientes</h4>
                        <h4 class="text_accion">Catologo</h4>
                    </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo $controlador->link_lista_com_producto; ?>">
                    <div class="cont_imagen_accion">
                        <img src="<?php echo $url_assets; ?>img/inicio/imagen_2.jpg">
                    </div>
                    <div class="cont_text_accion">
                        <h4 class="text_seccion">Productos</h4>
                        <h4 class="text_accion">Catologo</h4>
                    </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo $controlador->link_lista_com_sucursal; ?>">
                    <div class="cont_imagen_accion">
                        <img src="<?php echo $url_assets; ?>img/inicio/imagen_2.jpg">
                    </div>
                    <div class="cont_text_accion">
                        <h4 class="text_seccion">Sucursales</h4>
                        <h4 class="text_accion">Catologo</h4>
                    </div>
                </a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo $controlador->link_lista_tg_tipo_provision; ?>">
                    <div class="cont_imagen_accion">
                        <img src="<?php echo $url_assets; ?>img/inicio/imagen_2.jpg">
                    </div>
                    <div class="cont_text_accion">
                        <h4 class="text_seccion">Tipo Provision</h4>
                        <h4 class="text_accion">Catologo</h4>
                    </div>
                </a>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-2">
                <a href="<?php echo $controlador->link_lista_tg_sucursal_provision ; ?>">
                    <div class="cont_imagen_accion">
                        <img src="<?php echo $url_assets; ?>img/inicio/imagen_2.jpg">
                    </div>
                    <div class="cont_text_accion">
                        <h4 class="text_seccion">Sucursal Provision</h4>
                        <h4 class="text_accion">Catologo</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>