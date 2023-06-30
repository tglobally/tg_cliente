<?php
namespace tglobally\tg_cliente\models;
use base\orm\modelo;
use PDO;

class tg_sucursal_alianza extends modelo{

    public function __construct(PDO $link){
        $tabla = 'tg_sucursal_alianza';
        $columnas = array($tabla=>false,'tg_sucursal_alianza'=>$tabla);
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
    }
}