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

    public function asigna_provision(bool $header, bool $ws = false){
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

    public function asigna_provision_bd(bool $header, bool $ws = false){
        $inputs = $this->get_inputs();
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'No se pudo obtener los inputs', data: $inputs, header: $header, ws: $ws);
        }

        $this->link->beginTransaction();

        $registro['descripcion'] = $inputs['com_sucursal_id'].$inputs['org_sucursal_id'];
        $registro['com_sucursal_id'] = $inputs['com_sucursal_id'];
        $registro['org_sucursal_id'] = $inputs['org_sucursal_id'];
        $registro['codigo'] = (new tg_cliente_empresa($this->link))->get_codigo_aleatorio();
        $registro['codigo_bis'] = $registro['codigo'];
        $alta_cliente_empresa = (new tg_cliente_empresa($this->link))->alta_registro(registro: $registro);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al dar de alta cliente empresa', data: $alta_cliente_empresa,
                header: $header, ws: $ws);
        }

        foreach ($inputs['provisiones'] as $provision){
            $registro_provisiones['tg_cliente_empresa_id'] = $alta_cliente_empresa->registro_id;
            $registro_provisiones['tg_tipo_provision_id'] = $provision;
            $registro_provisiones['descripcion'] = $alta_cliente_empresa->registro_id;
            $registro_provisiones['codigo'] = (new tg_cliente_empresa($this->link))->get_codigo_aleatorio();
            $registro_provisiones['codigo_bis'] = $registro_provisiones['codigo'];
            $alta_provision_cliente = (new tg_cliente_empresa_provisiones($this->link))->alta_registro(registro: $registro_provisiones);
            if (errores::$error) {
                $this->link->rollBack();
                return $this->retorno_error(mensaje: 'Error al dar de alta provision cliente', data: $alta_provision_cliente,
                    header: $header, ws: $ws);
            }
        }

        $registro_conf['descripcion'] = $alta_cliente_empresa->registro_id;
        $registro_conf['tg_cliente_empresa_id'] = $alta_cliente_empresa->registro_id;
        $registro_conf['codigo'] = (new tg_cliente_empresa($this->link))->get_codigo_aleatorio();
        $registro_conf['codigo_bis'] = $registro_conf['codigo'];
        $registro_conf['estado'] = "activo";
        $alta_conf_provisiones = (new tg_conf_provisiones_cliente($this->link))->alta_registro(registro: $registro_conf);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al dar de alta conf. de provisiones cliente', data: $alta_conf_provisiones,
                header: $header, ws: $ws);
        }

        $this->link->commit();

        header('Location:'.$this->link_lista);

        return $alta_conf_provisiones;
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
