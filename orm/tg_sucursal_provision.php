<?php

namespace tglobally\tg_cliente\models;

use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class tg_sucursal_provision extends _modelo_parent
{

    public function __construct(PDO $link)
    {
        $tabla = 'tg_sucursal_provision';
        $columnas = array($tabla => false, 'com_sucursal' => $tabla, 'org_sucursal' => $tabla);
        $campos_obligatorios = array();

        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function get_provisiones_relacionadas(int $com_sucursal_id, int $org_sucursal_id): array|stdClass
    {
        if ($com_sucursal_id <= 0) {
            return $this->error->error(mensaje: 'Error $com_sucursal_id debe ser mayor a 0', data: $com_sucursal_id);
        }

        if ($org_sucursal_id <= 0) {
            return $this->error->error(mensaje: 'Error $org_sucursal_id debe ser mayor a 0', data: $org_sucursal_id);
        }

        $filtro['tg_sucursal_provision.tg_empresa'] = $com_sucursal_id;
        $filtro['tg_sucursal_provision.org_sucursal_id'] = $org_sucursal_id;
        $resultado = $this->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener provisiones relacionadas', data: $resultado);
        }

        return $resultado;
    }

}