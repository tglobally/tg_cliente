<?php /** @var controllers\controlador_tg_cte_tipo_alianza $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->codigo_bis; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->descripcion_select; ?>

<?php include (new views())->ruta_templates.'botons/submit/alta_bd_otro.php';?>