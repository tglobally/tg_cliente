<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace tglobally\tg_cliente\controllers;

use gamboamartin\errores\errores;
use gamboamartin\system\links_menu;
use gamboamartin\system\system;


use html\tg_cte_alianza_html;


use models\tg_cte_alianza;
use PDO;
use stdClass;
use tglobally\template_tg\html;

class controlador_com_cliente extends \gamboamartin\comercial\controllers\controlador_com_cliente {

    public function __construct(PDO $link, stdClass $paths_conf = new stdClass()){

        $html_base = new html();
        parent::__construct( link: $link, html: $html_base);
        $this->titulo_lista = 'Clientes';
    }

}
