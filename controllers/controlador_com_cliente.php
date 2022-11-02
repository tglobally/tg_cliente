<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace tglobally\tg_cliente\controllers;

use gamboamartin\comercial\models\com_sucursal;
use gamboamartin\errores\errores;
use gamboamartin\system\actions;
use gamboamartin\system\links_menu;
use gamboamartin\system\system;


use html\com_cliente_html;
use html\tg_cte_alianza_html;


use models\tg_com_rel_cliente;
use models\tg_cte_alianza;
use PDO;
use stdClass;
use tglobally\template_tg\html;

class controlador_com_cliente extends \gamboamartin\comercial\controllers\controlador_com_cliente {

    public array $com_clientes = array();
    public controlador_com_sucursal $controlador_com_sucursal;

    public function __construct(PDO $link, stdClass $paths_conf = new stdClass()){

        $html_base = new html();
        parent::__construct( link: $link, html: $html_base);
        $this->titulo_lista = 'Clientes';

        $this->controlador_com_sucursal= new controlador_com_sucursal(link:$this->link, paths_conf: $paths_conf);

    }

    public function asigna_alianza(bool $header, bool $ws = false){
        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();
        $com_cliente_id = (new com_cliente_html(html: $this->html_base))->select_com_cliente_id(
            cols:12, con_registros: true,id_selected: $this->registro_id,link:  $this->link, disabled: true);

        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener com_cliente_id',data:  $com_cliente_id, header: $header,ws:$ws);
        }

        $tg_cte_alianza_id = (new tg_cte_alianza_html(html: $this->html_base))->select_tg_cte_alianza_id(
            cols:12, con_registros: true,id_selected: -1,link:  $this->link);

        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener com_cliente_id',data:  $com_cliente_id, header: $header,ws:$ws);
        }

        $this->inputs->select->com_cliente_id = $com_cliente_id;
        $this->inputs->select->tg_cte_alianza_id = $tg_cte_alianza_id;


        $com_clientes = (new tg_cte_alianza(link: $this->link))->com_cliente_by_alianza(tg_cte_alianza_id: $this->registro_id);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener clientes',data:  $com_clientes, header: $header,ws:$ws);
        }

        $com_clientes = $this->rows_con_permisos(key_id:  'tg_com_rel_cliente_id',rows:  $com_clientes,seccion: 'tg_com_rel_cliente');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al integrar links',data:  $com_clientes, header: $header, ws: $ws);
        }

        $this->com_clientes = $com_clientes;
    }

    public function rel_cliente_alianza_bd(bool $header, bool $ws = false){

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

        $tg_cte_alianza_id = $_POST['tg_cte_alianza_id'];
        $com_cliente_id = $this->registro_id;

        $tg_com_rel_cliente_ins['tg_cte_alianza_id'] = $tg_cte_alianza_id;
        $tg_com_rel_cliente_ins['com_cliente_id'] = $com_cliente_id;

        $r_alta_bd = (new tg_com_rel_cliente($this->link))->alta_registro(registro: $tg_com_rel_cliente_ins);
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
                $id_retorno = $r_alta_bd->registro_id;
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

    public function sucursal(bool $header, bool $ws = false){

        $alta = $this->controlador_com_sucursal->alta(header: false);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar template', data: $alta, header: $header, ws: $ws);
        }

        $this->inputs = $this->controlador_com_sucursal->genera_inputs(
            keys_selects:  $this->controlador_com_sucursal->keys_selects);
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al generar inputs', data: $this->inputs);
            print_r($error);
            die('Error');
        }
    }

    public function alta_sucursal_bd(bool $header, bool $ws = false){
        $this->link->beginTransaction();

        $siguiente_view = (new actions())->init_alta_bd();
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(
                mensaje: 'Error al inicializar', data: $siguiente_view, header: $header, ws: $ws);
        }

        $_POST['com_cliente_id'] = $this->registro_id;

        $alta = (new com_sucursal($this->link))->alta_registro(registro: $_POST);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al dar de alta cuenta bancaria', data: $alta,
                header: $header, ws: $ws);
        }

        $this->link->commit();

        if ($header) {
            $this->retorno_base(registro_id:$this->registro_id, result: $alta,
                siguiente_view: "cuenta_bancaria", ws:  $ws);
        }
        if ($ws) {
            header('Content-Type: application/json');
            try {
                echo json_encode($alta, JSON_THROW_ON_ERROR);
            }
            catch (Throwable $e){
                $error = (new errores())->error(mensaje:'Error', data: $e);
                print_r($error);
            }
            exit;
        }
        $alta->siguiente_view = "cuenta_bancaria";

        return $alta;
    }

}
