<?php
namespace tglobally\tg_cliente\controllers;

use gamboamartin\comercial\models\com_sucursal;
use gamboamartin\empleado\models\em_empleado;
use gamboamartin\errores\errores;
use gamboamartin\system\init;
use html\com_sucursal_html;
use html\em_empleado_html;
use PDO;
use stdClass;
use tglobally\template_tg\html;

class controlador_com_sucursal extends \gamboamartin\comercial\controllers\controlador_com_sucursal
{

    /*public array $em_empleados = array();*/
    public array $keys_selects = array();

    public function __construct(PDO $link, stdClass $paths_conf = new stdClass())
    {
        $html_base = new html();
        parent::__construct(link: $link, html: $html_base);
        $this->titulo_lista = 'Sucursal';
    }

    public function asigna_empleado(bool $header, bool $ws = false){
        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();

        $em_empleado_id = (new em_empleado_html(html: $this->html_base))->select_em_empleado_id(
            cols:12, con_registros: true,id_selected: -1,link:  $this->link);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener em_empleado_id',data:  $em_empleado_id, header: $header,ws:$ws);
        }

        $com_sucursal_id = (new com_sucursal_html(html: $this->html_base))->select_com_sucursal_id(
            cols:12, con_registros: true,id_selected: $this->registro_id,link:  $this->link, disabled: true);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener com_cliente_id',data:  $com_sucursal_id, header: $header,ws:$ws);
        }

        $this->inputs->select->em_empleado_id = $em_empleado_id;
        $this->inputs->select->com_sucursal_id = $com_sucursal_id;


        /*$em_empleados = (new com_sucursal(link: $this->link))->em_empleado_by_sucursal(com_sucursal_id: $this->registro_id);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener empleados',data:  $em_empleados, header: $header,ws:$ws);
        }

        $em_empleados = $this->rows_con_permisos(key_id:  'nom_rel_empleado_sucursal_id',rows:  $em_empleados,seccion: 'nom_rel_empleado_sucursal');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al integrar links',data:  $em_empleados, header: $header, ws: $ws);
        }

        $this->em_empleados = $em_empleados;*/
    }

    public function rel_empleado_sucursal_bd(bool $header, bool $ws = false)
    {

    }
}
