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
use gamboamartin\system\links_menu;
use gamboamartin\system\system;


use html\tg_cte_alianza_html;


use models\tg_cte_alianza;
use PDO;
use stdClass;
use tglobally\template_tg\html;

class controlador_tg_cte_alianza extends system {

    public function __construct(PDO $link, html $html = new \tglobally\template_tg\html(),
                                stdClass $paths_conf = new stdClass()){
        $modelo = new tg_cte_alianza(link: $link);
        $html_ = new tg_cte_alianza_html(html: $html);
        $obj_link = new links_menu($this->registro_id);
        parent::__construct(html:$html_, link: $link,modelo:  $modelo, obj_link: $obj_link, paths_conf: $paths_conf);

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
                             bool $muestra_btn = true): array|string
    {
        $r_modifica =  parent::modifica(header: false,aplica_form:  false); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar template',data:  $r_modifica, header: $header,ws:$ws);
        }

        $inputs = (new tg_cte_alianza_html(html: $this->html_base))->inputs_tg_cte_alianza(controlador_tg_cte_alianza:$this);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al inicializar inputs',data:  $inputs, header: $header,ws:$ws);
        }

        return $r_modifica;
    }

}
