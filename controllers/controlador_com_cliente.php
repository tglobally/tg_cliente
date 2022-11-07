<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace tglobally\tg_cliente\controllers;

use gamboamartin\comercial\models\com_cliente;
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

    public array $tg_cte_alianzas = array();
    public controlador_com_sucursal $controlador_com_sucursal;

    public function __construct(PDO $link, stdClass $paths_conf = new stdClass()){

        $html_base = new html();
        parent::__construct( link: $link, html: $html_base);
        $this->titulo_lista = 'Clientes';

        $this->controlador_com_sucursal= new controlador_com_sucursal(link:$this->link, paths_conf: $paths_conf);

    }

    public function alta_sucursal_bd(bool $header, bool $ws = false){
        $this->link->beginTransaction();

        $siguiente_view = (new actions())->init_alta_bd();
        if(errores::$error){
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al obtener siguiente view', data: $siguiente_view,
                header:  $header, ws: $ws);
        }


        if(isset($_POST['guarda'])){
            unset($_POST['guarda']);
        }
        if(isset($_POST['btn_action_next'])){
            unset($_POST['btn_action_next']);
        }


        $registro = $_POST;
        $registro['com_cliente_id'] = $this->registro_id;

        $r_alta_sucursal_bd = (new com_sucursal($this->link))->alta_registro(registro:$registro); // TODO: Change the autogenerated stub
        if(errores::$error){
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al dar de alta sucursal',data:  $r_alta_sucursal_bd,
                header: $header,ws:$ws);
        }


        $this->link->commit();

        if($header){

            $retorno = (new actions())->retorno_alta_bd(link: $this->link, registro_id:$this->registro_id,
                seccion: $this->tabla, siguiente_view: $siguiente_view);
            if(errores::$error){
                return $this->retorno_error(mensaje: 'Error al dar de alta registro', data: $r_alta_sucursal_bd,
                    header:  true, ws: $ws);
            }
            header('Location:'.$retorno);
            exit;
        }
        if($ws){
            header('Content-Type: application/json');
            echo json_encode($r_alta_sucursal_bd, JSON_THROW_ON_ERROR);
            exit;
        }

        return $r_alta_sucursal_bd;
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
            return $this->retorno_error(mensaje: 'Error al obtener com_cliente_id',data:  $tg_cte_alianza_id, header: $header,ws:$ws);
        }

        $this->inputs->select->com_cliente_id = $com_cliente_id;
        $this->inputs->select->tg_cte_alianza_id = $tg_cte_alianza_id;


        $tg_cte_alianzas = (new tg_cte_alianza(link: $this->link))->tg_cte_alianza_by_cliente(com_cliente_id: $this->registro_id);;
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener clientes',data:  $tg_cte_alianzas, header: $header,ws:$ws);
        }

        $tg_cte_alianzas = $this->rows_con_permisos(key_id:  'tg_com_rel_cliente_id',rows:  $tg_cte_alianzas,seccion: 'tg_com_rel_cliente');
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al integrar links',data:  $tg_cte_alianzas, header: $header, ws: $ws);
        }

        $this->tg_cte_alianzas = $tg_cte_alianzas;
    }

    private function data_sucursal_btn(array $sucursal): array
    {

        $params['com_sucursal_id'] = $sucursal['com_sucursal_id'];

        $btn_elimina = $this->html_base->button_href(accion:'elimina_bd',etiqueta:  'Elimina',
            registro_id:  $sucursal['com_sucursal_id'], seccion: 'com_sucursal',style:  'danger');

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar btn',data:  $btn_elimina);
        }
        $sucursal['link_elimina'] = $btn_elimina;


        $btn_modifica = $this->html_base->button_href(accion:'modifica_sucursal',etiqueta:  'Modifica',
            registro_id:  $sucursal['com_cliente_id'], seccion: 'com_cliente',style:  'warning', params: $params);

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al generar btn',data:  $btn_elimina);
        }
        $sucursal['link_modifica'] = $btn_modifica;

        return $sucursal;
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
        $com_cliente_id = (new com_cliente_html(html: $this->html_base))->select_com_cliente_id(
            cols:6, con_registros: true,id_selected: $this->registro_id,link:  $this->link, disabled: true);

        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener com_cliente_id',data:  $com_cliente_id, header: $header,ws:$ws);
        }
        $this->inputs->select->com_cliente_id = $com_cliente_id;


        $sucursales = (new com_sucursal($this->link))->sucursales(com_cliente_id: $this->registro_id);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener sucursales',data:  $sucursales, header: $header,ws:$ws);
        }

        foreach ($sucursales->registros as $indice=>$sucursal){

            $sucursal = $this->data_sucursal_btn(sucursal:$sucursal);
            if(errores::$error){
                return $this->retorno_error(mensaje: 'Error al asignar botones',data:  $sucursal, header: $header,ws:$ws);
            }
            $sucursales->registros[$indice] = $sucursal;

        }

        $this->sucursales = $sucursales;

    }

}
