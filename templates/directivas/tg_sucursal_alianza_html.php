<?php
namespace html;

use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use models\base\limpieza;
use tglobally\tg_cliente\controllers\controlador_tg_cte_alianza;

use stdClass;
use PDO;
use tglobally\tg_cliente\controllers\controlador_tg_sucursal_alianza;

class tg_sucursal_alianza_html extends html_controler {

    private function asigna_inputs(controlador_tg_sucursal_alianza $controler, stdClass $inputs): array|stdClass
    {
        $controler->inputs->select = new stdClass();

        $controler->inputs->select->com_sucursal_id = $inputs->selects->com_sucursal_id;
        $controler->inputs->select->tg_cte_alianza_id = $inputs->selects->tg_cte_alianza_id;

        return $controler->inputs;
    }

    public function genera_inputs_alta(controlador_tg_sucursal_alianza $controler,PDO $link): array|stdClass
    {
        $keys_selects = array();
        $inputs = $this->init_alta(keys_selects: $keys_selects, link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar inputs',data:  $inputs);

        }
        $inputs_asignados = $this->asigna_inputs(controler:$controler, inputs: $inputs);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al asignar inputs',data:  $inputs_asignados);
        }

        return $inputs_asignados;
    }

    protected function init_alta(array $keys_selects, PDO $link): array|stdClass
    {
        $selects = $this->selects_alta(keys_selects: $keys_selects, link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar selects',data:  $selects);
        }

        $texts = $this->texts_alta(row_upd: new stdClass(), value_vacio: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar texts',data:  $texts);
        }

        $alta_inputs = new stdClass();
        $alta_inputs->selects = $selects;
        $alta_inputs->texts = $texts;

        return $alta_inputs;
    }

    protected function selects_alta(array $keys_selects, PDO $link): array|stdClass
    {
        $selects = new stdClass();

        $com_sucursal_html = new com_sucursal_html(html:$this->html_base);
        $select = $com_sucursal_html->select_com_sucursal_id(cols: 12, con_registros:true,
            id_selected:-1,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }
        $selects->com_sucursal_id = $select;

        $tg_cte_alianza_html = new tg_cte_alianza_html(html:$this->html_base);
        $select = $tg_cte_alianza_html->select_tg_cte_alianza_id(cols: 12, con_registros:true,
            id_selected:-1,link: $link);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select',data:  $select);
        }
        $selects->tg_cte_alianza_id = $select;

        return $selects;
    }

    protected function texts_alta(stdClass $row_upd, bool $value_vacio, stdClass $params = new stdClass()): array|stdClass
    {
        $texts = new stdClass();

        return $texts;
    }

}
