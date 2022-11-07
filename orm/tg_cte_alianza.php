<?php
namespace models;
use base\orm\modelo;
use gamboamartin\errores\errores;
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

    public function com_cliente_by_alianza(int $tg_cte_alianza_id): array
    {

        $filtro['tg_cte_alianza.id'] = $tg_cte_alianza_id;
        $r_tg_com_cliente_alianza = (new tg_com_rel_cliente($this->link))->filtro_and(filtro:$filtro);
        if(errores::$error){

            return $this->error->error(mensaje: 'Error al limpiar datos',data:  $r_tg_com_cliente_alianza);
        }
        return $r_tg_com_cliente_alianza->registros;

    }

    public function tg_cte_alianza_by_cliente(int $com_cliente_id): array
    {

        $filtro['com_cliente.id'] = $com_cliente_id;
        $r_tg_com_cliente_alianza = (new tg_com_rel_cliente($this->link))->filtro_and(filtro:$filtro);
        if(errores::$error){

            return $this->error->error(mensaje: 'Error al limpiar datos',data:  $r_tg_com_cliente_alianza);
        }
        return $r_tg_com_cliente_alianza->registros;

    }

}