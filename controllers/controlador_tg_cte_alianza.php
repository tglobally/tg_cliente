<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace tglobally\tg_cliente\controllers;

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

class controlador_tg_cte_alianza extends system {

    public array $com_clientes = array();

    public function __construct(PDO $link, html $html = new \tglobally\template_tg\html(),
                                stdClass $paths_conf = new stdClass()){
        $modelo = new tg_cte_alianza(link: $link);
        $html_ = new tg_cte_alianza_html(html: $html);
        $obj_link = new links_menu(link: $link,registro_id: $this->registro_id);

        $columns["tg_cte_alianza_id"]["titulo"] = "Id";
        $columns["tg_cte_alianza_codigo"]["titulo"] = "Codigo";
        $columns["tg_cte_alianza_codigo_bis"]["titulo"] = "Codigo bis";
        $columns["tg_cte_alianza_descripcion"]["titulo"] = "Descripcion";
        $columns["tg_cte_alianza_tipo_alianza"]["titulo"] = "Tipo alianza";

        $filtro = array("tg_cte_alianza.id","tg_cte_alianza.codigo","tg_cte_alianza.codigo_bis",
            "tg_cte_alianza.descripcion");

        $datatables = new stdClass();
        $datatables->columns = $columns;

        parent::__construct(html: $html_, link: $link, modelo: $modelo, obj_link: $obj_link, datatables: $datatables,
            paths_conf: $paths_conf);

        $obj_link->genera_links($this);
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al inicializar links', data: $obj_link);
            print_r($error);
            die('Error');
        }
        $this->titulo_lista = 'Alianza';
    }

    public function alta(bool $header, bool $ws = false): array|string
    {
        $r_alta =  parent::alta(header: false, ws: false); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar template',data:  $r_alta, header: $header,ws:$ws);
        }

        $inputs = (new tg_cte_alianza_html(html: $this->html_base))->genera_inputs_alta(controler: $this, link: $this->link);
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al generar inputs',data:  $inputs);
            print_r($error);
            die('Error');
        }

        return $r_alta;
    }

    public function alta_bd(bool $header, bool $ws = false): array|stdClass
    {
        if(isset($_POST['dp_pais_id'])){
            unset($_POST['dp_pais_id']);
        }
        if(isset($_POST['dp_estado_id'])){
            unset($_POST['dp_estado_id']);
        }
        if(isset($_POST['dp_municipio_id'])){
            unset($_POST['dp_municipio_id']);
        }
        if(isset($_POST['dp_cp_id'])){
            unset($_POST['dp_cp_id']);
        }
        if(isset($_POST['dp_colonia_postal_id'])){
            unset($_POST['dp_colonia_postal_id']);
        }

        $transaccion_previa = false;
        if($this->link->inTransaction()){
            $transaccion_previa = true;
        }
        if(!$transaccion_previa) {
            $this->link->beginTransaction();
        }

        $siguiente_view = (new actions())->init_alta_bd();
        if(errores::$error){
            if(!$transaccion_previa) {
                $this->link->rollBack();
            }
            return $this->retorno_error(mensaje: 'Error al obtener siguiente view', data: $siguiente_view,
                header:  $header, ws: $ws);
        }
        $seccion_retorno = $this->tabla;
        if(isset($_POST['seccion_retorno'])){
            $seccion_retorno = $_POST['seccion_retorno'];
            unset($_POST['seccion_retorno']);
        }

        $r_alta_bd =  parent::alta_bd(header: false); // TODO: Change the autogenerated stub
        if(errores::$error){
            if(!$transaccion_previa) {
                $this->link->rollBack();
            }
            return $this->retorno_error(mensaje: 'Error al ejecutar template',data:  $r_alta_bd, header: $header,ws:$ws);
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

    public function asigna_cliente(bool $header, bool $ws = false){
        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();

        $com_cliente_id = (new com_cliente_html(html: $this->html_base))->select_com_cliente_id(
            cols:12, con_registros: true,id_selected: -1,link:  $this->link);

        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener com_cliente_id',data:  $com_cliente_id, header: $header,ws:$ws);
        }

        $tg_cte_alianza_id = (new tg_cte_alianza_html(html: $this->html_base))->select_tg_cte_alianza_id(
            cols:12, con_registros: true,id_selected: $this->registro_id,link:  $this->link, disabled: true);

        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener cte_alianza_id',data:  $tg_cte_alianza_id, header: $header,ws:$ws);
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

    public function lista(bool $header, bool $ws = false): array
    {
        $r_lista = parent::lista(header:false,ws: false); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al ejecutar template',data:  $_POST, header: $header,ws:$ws);
        }

        $links = $this->registros;

        $registros = $this->modelo->registros(return_obj: true);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al obtener registros',data:  $registros, header: $header,ws:$ws);
        }

        foreach ($registros as $indice=>$registro){
            foreach($links as $link){

                if((int)$registro->tg_cte_alianza_id  === (int)$link->tg_cte_alianza_id){
                    $registro->link_modifica = $link->link_modifica;
                    $registro->link_elimina_bd = $link->link_elimina_bd;
                }
            }
            $registros[$indice] = $registro;

        }

        $this->registros = $registros;


        return $r_lista;
    }

    public function modifica(bool $header, bool $ws = false, string $breadcrumbs = '', bool $aplica_form = true,
                             bool $muestra_btn = true): array
    {

        $r_modifica =  parent::modifica(header: false,aplica_form:  false); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar template',data:  $r_modifica, header: $header,ws:$ws);
        }

        $inputs = (new tg_cte_alianza_html(html: $this->html_base))->inputs_tg_cte_alianza(
            controlador_tg_cte_alianza:$this);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al inicializar inputs',data:  $inputs, header: $header,ws:$ws);
        }

        return $r_modifica;
    }

    public function modifica_bd(bool $header, bool $ws): array|stdClass
    {
        if(isset($_POST['dp_pais_id'])){
            unset($_POST['dp_pais_id']);
        }
        if(isset($_POST['dp_estado_id'])){
            unset($_POST['dp_estado_id']);
        }
        if(isset($_POST['dp_municipio_id'])){
            unset($_POST['dp_municipio_id']);
        }
        if(isset($_POST['dp_cp_id'])){
            unset($_POST['dp_cp_id']);
        }
        if(isset($_POST['dp_colonia_postal_id'])){
            unset($_POST['dp_colonia_postal_id']);
        }

        $r_modifica_bd = parent::modifica_bd($header, $ws); // TODO: Change the autogenerated stub
        if(errores::$error){
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al modificar registro',data:  $r_modifica_bd, header: $header,ws:$ws);
        }

        return $r_modifica_bd;
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

        $tg_cte_alianza_id = $this->registro_id;
        $com_cliente_id = $_POST['com_cliente_id'];

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

}
