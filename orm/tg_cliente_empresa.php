<?php
namespace tglobally\tg_cliente\models;

use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;

class tg_cliente_empresa extends modelo{

    public function __construct(PDO $link){
        $tabla = 'tg_cliente_empresa';
        $columnas = array($tabla=>false, 'com_sucursal' => $tabla, 'org_sucursal' => $tabla);
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);

        $this->NAMESPACE = __NAMESPACE__;
    }

}