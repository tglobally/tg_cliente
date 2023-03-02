<?php
namespace tglobally\tg_cliente\controllers;

use gamboamartin\comercial\models\com_sucursal;
use gamboamartin\empleado\models\em_empleado;
use gamboamartin\empleado\models\em_rel_empleado_sucursal;
use gamboamartin\errores\errores;
use gamboamartin\nomina\models\nom_rel_empleado_sucursal;
use gamboamartin\system\actions;
use html\com_sucursal_html;
use html\em_empleado_html;
use PDO;
use stdClass;
use tglobally\template_tg\html;

class controlador_com_sucursal extends \gamboamartin\comercial\controllers\controlador_com_sucursal
{

    public array $em_empleados = array();
    public stdClass|array $keys_selects = array();

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

        $em_empleados = (new com_sucursal(link: $this->link))->em_empleado_by_sucursal(com_sucursal_id: $this->registro_id);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener empleados',data:  $em_empleados, header: $header,ws:$ws);
        }

        $em_empleados = $this->rows_con_permisos(key_id:  'nom_rel_empleado_sucursal_id',rows:  $em_empleados,seccion: 'nom_rel_empleado_sucursal');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al integrar links',data:  $em_empleados, header: $header, ws: $ws);
        }

        $this->em_empleados = $em_empleados;

    }

    public function rel_empleado_sucursal_bd(bool $header, bool $ws = false){
        $this->link->beginTransaction();

        $siguiente_view = (new actions())->init_alta_bd();
        if(errores::$error){

            return $this->retorno_error(mensaje: 'Error al obtener siguiente view', data: $siguiente_view,
                header:  $header, ws: $ws);
        }
        $seccion_retorno = $this->tabla;
        if(isset($_POST['seccion_retorno'])){
            $seccion_retorno = $_POST['seccion_retorno'];
            unset($_POST['seccion_retorno']);
        }

        $com_sucursal_id = $this->registro_id;
        $em_empleado_id = $_POST['em_empleado_id'];

        $nom_rel_empleado_sucursal_ins['com_sucursal_id'] = $com_sucursal_id;
        $nom_rel_empleado_sucursal_ins['em_empleado_id'] = $em_empleado_id;

        $r_alta_bd = (new nom_rel_empleado_sucursal($this->link))->alta_registro(registro: $nom_rel_empleado_sucursal_ins);
        if(errores::$error){
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al insertar registro',data:  $r_alta_bd, header: $header,ws:$ws);
        }
        $this->link->commit();

        $id_retorno = -1;
        if(isset($_POST['id_retorno'])){
            $id_retorno = $_POST['id_retorno'];
            unset($_POST['id_retorno']);
        }

        if($header){
            if($id_retorno === -1) {
                $id_retorno = $this->registro_id;
            }
            $this->retorno_base(registro_id:$id_retorno, result: $r_alta_bd, siguiente_view: $siguiente_view,
                ws:  $ws,seccion_retorno: $seccion_retorno);
        }
        if($ws){
            header('Content-Type: application/json');
            echo json_encode($r_alta_bd, JSON_THROW_ON_ERROR);
            exit;
        }

        return $r_alta_bd;
    }
}
