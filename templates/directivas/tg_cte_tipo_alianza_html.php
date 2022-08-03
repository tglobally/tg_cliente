<?php
namespace html;


use gamboamartin\comercial\controllers\controlador_tg_cte_tipo_alianza;
use gamboamartin\errores\errores;
use gamboamartin\organigrama\controllers\controlador_org_sucursal;
use gamboamartin\system\html_controler;
use models\tg_cte_tipo_alianza;
use PDO;
use stdClass;


class tg_cte_tipo_alianza_html extends html_controler {


    public function tg_cte_tipo_alianza_id(int $cols, bool $con_registros,int $id_selected, PDO $link,
                                        array $filtro = array()): array|string
    {
        $modelo = new tg_cte_tipo_alianza($link);

        $select = $this->select_catalogo(cols: $cols, con_registros: $con_registros, id_selected: $id_selected,
            modelo: $modelo, filtro: $filtro, label: 'Tipo alianza');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }


}
