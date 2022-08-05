<?php
namespace tglobally\tg_cliente\controllers;

use gamboamartin\errores\errores;
use gamboamartin\system\init;
use models\org_empresa;
use models\org_sucursal;
use PDO;
use stdClass;
use tglobally\template_tg\html;

class controlador_com_sucursal extends \gamboamartin\comercial\controllers\controlador_com_sucursal {


    public function __construct(PDO $link, stdClass $paths_conf = new stdClass()){
        $html_base = new html();
        parent::__construct( link: $link, html: $html_base);
        $this->titulo_lista = 'Sucursal';
    }


}
