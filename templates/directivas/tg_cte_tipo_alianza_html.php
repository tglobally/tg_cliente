<?php
namespace html;

use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\template\directivas;
use models\tg_cte_tipo_alianza;
use PDO;

class tg_cte_tipo_alianza_html extends html_controler {

    public function select_tg_cte_tipo_alianza_id(int $cols, bool $con_registros, int $id_selected, PDO $link,
                                                 array $filtro = array()): array|string
    {

        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }
        $modelo = new tg_cte_tipo_alianza($link);

        $select = $this->select_catalogo(cols: $cols, con_registros: $con_registros, id_selected: $id_selected,
            modelo: $modelo, filtro: $filtro, label: 'Tipo de Alianza');
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }

}
