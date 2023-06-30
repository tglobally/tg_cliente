<?php
namespace tglobally\tg_cliente\models;

use base\orm\_modelo_parent;
use PDO;

class tg_sucursal_provision extends _modelo_parent {

    public function __construct(PDO $link){
        $tabla = 'tg_sucursal_provision';
        $columnas = array($tabla=>false, 'com_sucursal'=>$tabla ,'org_sucursal'=>$tabla);
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);

        $this->NAMESPACE = __NAMESPACE__;
    }

}