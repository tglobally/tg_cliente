<?php
namespace tglobally\tg_cliente\models;

use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;

class tg_cliente_empresa_provisiones extends modelo{

    public function __construct(PDO $link){
        $tabla = 'tg_cliente_empresa_provisiones';
        $columnas = array($tabla=>false);
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);

        $this->NAMESPACE = __NAMESPACE__;
    }

}