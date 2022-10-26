<?php
namespace models;
use base\orm\modelo;
use PDO;

class tg_cte_alianza extends modelo{

    public function __construct(PDO $link){
        $tabla = __CLASS__;
        $columnas = array($tabla=>false,'tg_cte_tipo_alianza'=>$tabla,'dp_calle_pertenece'=>$tabla,
            'dp_colonia_postal'=>'dp_calle_pertenece','dp_cp'=>'dp_colonia_postal','dp_municipio'=>'dp_cp',
            'dp_estado'=>'dp_municipio','dp_pais'=>'dp_estado');
        $campos_obligatorios = array();

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);

        $this->NAMESPACE = __NAMESPACE__;
    }
}