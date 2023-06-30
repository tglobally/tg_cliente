<?php
namespace tglobally\tg_cliente\models;

use base\orm\modelo;
use gamboamartin\comercial\models\com_cliente;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class tg_com_rel_cliente extends modelo{

    public function __construct(PDO $link){
        $tabla = 'tg_com_rel_cliente';
        $columnas = array($tabla=>false,'com_cliente'=>$tabla,'tg_cte_alianza'=>$tabla);
        $campos_obligatorios = array('com_cliente_id','tg_cte_alianza_id');

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);
    }

    public function alta_bd(): array|stdClass
    {

        $com_cliente = (new com_cliente($this->link))->registro(
            registro_id: $this->registro['com_cliente_id'], columnas_en_bruto: true, retorno_obj: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar',data:  $com_cliente);
        }
        $tg_cte_alianza = (new tg_cte_alianza($this->link))->registro(
            registro_id: $this->registro['tg_cte_alianza_id'], columnas_en_bruto: true, retorno_obj: true);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar',data:  $tg_cte_alianza);
        }

        if(!isset($this->registro['codigo'])){
            $codigo = $com_cliente->codigo.' '.$tg_cte_alianza->codigo;
            $this->registro['codigo'] = $codigo;
        }
        if(!isset($this->registro['descripcion'])){
            $descripcion = $com_cliente->rfc.' '.$tg_cte_alianza->codigo;
            $this->registro['descripcion'] = $descripcion;
        }
        if(!isset($this->registro['codigo_bis'])){

            $this->registro['codigo_bis'] = strtoupper($codigo);
        }

        $r_alta_bd = parent::alta_bd(); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al insertar',data:  $r_alta_bd);
        }
        return $r_alta_bd;
    }
}