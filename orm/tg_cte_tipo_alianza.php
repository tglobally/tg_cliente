<?php
namespace tglobally\tg_cliente\models;
use base\orm\modelo;
use PDO;

class tg_cte_tipo_alianza extends modelo{

    public function __construct(PDO $link){
        $tabla = 'tg_cte_tipo_alianza';
        $columnas = array($tabla=>false);
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);

        $this->NAMESPACE = __NAMESPACE__;

    }
}