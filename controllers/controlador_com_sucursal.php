<?php
namespace tglobally\tg_cliente\controllers;

use gamboamartin\comercial\models\com_sucursal;
use gamboamartin\empleado\models\em_empleado;
use gamboamartin\empleado\models\em_rel_empleado_sucursal;
use gamboamartin\errores\errores;
use gamboamartin\nomina\models\nom_rel_empleado_sucursal;
use gamboamartin\organigrama\html\org_sucursal_html;
use gamboamartin\system\actions;
use html\com_sucursal_html;
use html\em_empleado_html;
use PDO;
use stdClass;
use tglobally\template_tg\html;
use tglobally\tg_cliente\models\tg_cliente_empresa;
use tglobally\tg_cliente\models\tg_cliente_empresa_provisiones;
use tglobally\tg_cliente\models\tg_conf_provisiones_cliente;
use tglobally\tg_cliente\models\tg_tipo_provision;
use tglobally\tg_empleado\models\tg_conf_provision;
use tglobally\tg_empleado\models\tg_conf_provisiones_empleado;
use tglobally\tg_empleado\models\tg_empleado_sucursal;

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

        $tg_tipo_provision_id = (new com_sucursal_html(html: $this->html_base))->select_com_sucursal_id(
            cols:12, con_registros: true,id_selected: $this->registro_id,link:  $this->link, disabled: true);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener tg_tipo_provision_id',data:  $tg_tipo_provision_id, header: $header,ws:$ws);
        }

        $this->inputs->select->em_empleado_id = $em_empleado_id;
        $this->inputs->select->com_sucursal_id = $com_sucursal_id;
        $this->inputs->select->tg_tipo_provision_id = $tg_tipo_provision_id;

        $em_empleados = (new nom_rel_empleado_sucursal(link: $this->link))->em_empleado_by_nom_rel_empleado_sucursal(com_sucursal_id: $this->registro_id);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener empleados',data:  $em_empleados, header: $header,ws:$ws);
        }

        $em_empleados = $this->rows_con_permisos(key_id:  'nom_rel_empleado_sucursal_id',rows:  $em_empleados,seccion: 'nom_rel_empleado_sucursal');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al integrar links',data:  $em_empleados, header: $header, ws: $ws);
        }

        $this->em_empleados = $em_empleados;

    }

    public function asigna_provision(bool $header, bool $ws = false, array $not_actions = array()){
        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();

        $org_sucursal_id = (new org_sucursal_html(html: $this->html_base))->select_org_sucursal_id(
            cols:12, con_registros: true,id_selected: -1,link:  $this->link,label: "Empresa");
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener org_sucursal_id',data:  $org_sucursal_id, header: $header,ws:$ws);
        }

        $com_sucursal_id = (new com_sucursal_html(html: $this->html_base))->select_com_sucursal_id(
            cols:12, con_registros: true,id_selected: $this->registro_id,link:  $this->link, disabled: true,label: "Cliente");
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener com_cliente_id',data:  $com_sucursal_id, header: $header,ws:$ws);
        }
        
        $this->inputs->select->org_sucursal_id = $org_sucursal_id;
        $this->inputs->select->com_sucursal_id = $com_sucursal_id;

        $seccion = "tg_conf_provisiones_empleado";

        $data_view = new stdClass();
        $data_view->names = array('Id', 'Cliente','Empresa','Provisión', 'Empleado');
        $data_view->keys_data = array($seccion . "_id", "com_sucursal_descripcion", "org_sucursal_descripcion",
            "tg_tipo_provision_descripcion", "em_empleado_nombre_completo");
        $data_view->key_actions = 'acciones';
        $data_view->namespace_model = 'tglobally\\tg_empleado\\models';
        $data_view->name_model_children = $seccion;

        $contenido_table = $this->contenido_children(data_view: $data_view, next_accion: __FUNCTION__,
            not_actions: $not_actions);
        if (errores::$error) {
            return $this->retorno_error(
                mensaje: 'Error al obtener tbody', data: $contenido_table, header: $header, ws: $ws);
        }

        return $contenido_table;
    }

    public function asigna_provision_bd(bool $header, bool $ws = false){
        $inputs = $this->get_inputs();
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'No se pudo obtener los inputs', data: $inputs, header: $header, ws: $ws);
        }

        $this->link->beginTransaction();

        $siguiente_view = $this->inicializa_transaccion();
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(
                mensaje: 'Error al inicializar', data: $siguiente_view, header: $header, ws: $ws);
        }

        $filtro['tg_conf_provision.com_sucursal_id'] = $inputs['com_sucursal_id'];
        $filtro['tg_conf_provision.org_sucursal_id'] = $inputs['org_sucursal_id'];
        $filtro['tg_conf_provision.estado'] = "activo";
        $configuracion = (new tg_conf_provision($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al obtener configuracion', data: $configuracion);
        }

        if ($configuracion->n_registros <= 0){
            $alta['com_sucursal_id'] = $inputs['com_sucursal_id'];
            $alta['org_sucursal_id'] = $inputs['org_sucursal_id'];
            $alta['estado'] = "activo";
            $alta['descripcion'] = "CONF.";
            $alta['codigo'] = $this->modelo->get_codigo_aleatorio();
            $alta['codigo_bis'] = $alta['codigo'];

            $alta_bd = (new tg_conf_provision($this->link))->alta_registro(registro: $alta);
            if (errores::$error) {
                $this->link->rollBack();
                return $this->errores->error(mensaje: 'Error al insertar configuracion', data: $alta_bd);
            }
            $configuracion->registros[0]['tg_conf_provision_id'] = $alta_bd->registro_id;
        }

        $filtro = array();
        $filtro['tg_conf_provisiones_empleado.tg_conf_provision_id'] = $configuracion->registros[0]['tg_conf_provision_id'];
        $borrados = (new tg_conf_provisiones_empleado($this->link))->elimina_con_filtro_and(filtro: $filtro);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->errores->error(mensaje: 'Error al eliminar provisiones', data: $borrados);
        }

        $filtro = array();
        $filtro['tg_empleado_sucursal.com_sucursal_id'] = $inputs['com_sucursal_id'];
        $filtro['tg_empleado_sucursal.org_sucursal_id'] = $inputs['org_sucursal_id'];
        $empleados = (new tg_empleado_sucursal($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al obtener empleados', data: $empleados);
        }

        foreach ($empleados->registros as $registro){
            foreach ($inputs['provisiones'] as $key => $provision){
                $alta['tg_conf_provision_id'] = $configuracion->registros[0]['tg_conf_provision_id'];
                $alta['em_empleado_id'] = $registro['em_empleado_id'];
                $alta['tg_tipo_provision_id'] = $provision;
                $alta['descripcion'] = $key;
                $alta['codigo'] = $this->modelo->get_codigo_aleatorio();
                $alta['codigo_bis'] = $alta['codigo'];
                $alta_bd = (new tg_conf_provisiones_empleado($this->link))->alta_registro(registro: $alta);
                if (errores::$error) {
                    $this->link->rollBack();
                    return $this->errores->error(mensaje: 'Error al insertar provision', data: $alta_bd);
                }
            }
        }

        $this->link->commit();
        $link = "./index.php?seccion=com_sucursal&accion=asigna_provision&registro_id=" . $this->registro_id;
        $link .= "&session_id=$this->session_id";
        header('Location:' . $link);
        exit();
    }

    private function inicializa_transaccion(): array|string
    {
        $siguiente_view = (new actions())->init_alta_bd();
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al obtener siguiente view', data: $siguiente_view);
        }

        $limpia = $this->clean_post();
        if (errores::$error) {

            return $this->errores->error(mensaje: 'Error al limpiar post', data: $limpia);
        }

        return $siguiente_view;
    }

    private function clean_post(): array
    {
        if (isset($_POST['btn_action_next'])) {
            unset($_POST['btn_action_next']);
        }
        return $_POST;
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



    public function get_inputs(): array|stdClass{

        $inputs = array('provisiones' => array());

        if (!isset($_POST['org_sucursal_id']) && $_POST['org_sucursal_id'] === "" && $_POST['org_sucursal_id'] <= 0) {
            return $this->errores->error(mensaje: 'Error org_sucursal_id es requerido', data: $_POST);
        }

        if (isset($_POST['prima_vacacional']) && $_POST['prima_vacacional'] === "activo") {
            $prima_vacacional = $this->get_provision(provision: "PRIMA VACACIONAL");
            if (errores::$error) {
                return $this->errores->error(mensaje: 'Error al obtener PRIMA VACACIONAL', data: $prima_vacacional);
            }

            $inputs['provisiones']['prima_vacacional'] =  $prima_vacacional;
        }

        if (isset($_POST['vacaciones']) && $_POST['vacaciones'] === "activo") {
            $vacaciones = $this->get_provision(provision: "VACACIONES");
            if (errores::$error) {
                return $this->errores->error(mensaje: 'Error al obtener VACACIONES', data: $vacaciones);
            }

            $inputs['provisiones']['vacaciones'] =  $vacaciones;
        }

        if (isset($_POST['prima_antiguedad']) && $_POST['prima_antiguedad'] === "activo") {
            $prima_antiguedad = $this->get_provision(provision: "PRIMA DE ANTIGÜEDAD");
            if (errores::$error) {
                return $this->errores->error(mensaje: 'Error al obtener PRIMA DE ANTIGÜEDAD', data: $prima_antiguedad);
            }

            $inputs['provisiones']['prima_antiguedad'] =  $prima_antiguedad;
        }

        if (isset($_POST['aguinaldo']) && $_POST['aguinaldo'] === "activo") {
            $aguinaldo = $this->get_provision(provision: "GRATIFICACIÓN ANUAL (AGUINALDO)");
            if (errores::$error) {
                return $this->errores->error(mensaje: 'Error al obtener GRATIFICACIÓN ANUAL (AGUINALDO)', data: $aguinaldo);
            }

            $inputs['provisiones']['aguinaldo'] =  $aguinaldo;
        }

        $inputs['com_sucursal_id'] = $this->registro_id;
        $inputs['org_sucursal_id'] = $_POST['org_sucursal_id'];

        return $inputs;
    }

    public function get_provision(string $provision): string|array{
        $filtro = array("tg_tipo_provision.descripcion" => $provision);
        $response = (new tg_tipo_provision($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error obtener tipo de provision', data: $response);
        }

        if ($response->n_registros <= 0){
            return $this->errores->error(mensaje: "Error $provision no existe", data: $response);
        }

        return $response->registros[0]['tg_tipo_provision_id'];
    }


}
