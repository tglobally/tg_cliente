<?php
namespace tests\templates\directivas;


use gamboamartin\errores\errores;
use gamboamartin\template_1\html;

use gamboamartin\test\liberator;
use gamboamartin\test\test;


use html\tg_cte_alianza_html;
use stdClass;


class tg_cte_alianza_htmlTest extends test {
    public errores $errores;
    private stdClass $paths_conf;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->errores = new errores();
        $this->paths_conf = new stdClass();
        $this->paths_conf->generales = '/var/www/html/cat_sat/config/generales.php';
        $this->paths_conf->database = '/var/www/html/cat_sat/config/database.php';
        $this->paths_conf->views = '/var/www/html/cat_sat/config/views.php';
    }


    public function test_init_dps_modifica(): void
    {
        errores::$error = false;

        $_GET['seccion'] = 'cat_sat_tipo_persona';
        $_GET['accion'] = 'lista';
        $_SESSION['grupo_id'] = 1;
        $_SESSION['usuario_id'] = 2;
        $_GET['session_id'] = '1';

        $html = new html();
        $html = new tg_cte_alianza_html($html);
        $html = new liberator($html);


        $link = $this->link;
        $row_upd = new stdClass();
        $row_upd->dp_calle_pertenece_id = 1;
        $resultado = $html->init_dps_modifica($link, $row_upd);

        $this->assertIsObject($resultado);
        $this->assertNotTrue(errores::$error);
        $this->assertEquals(1, $resultado->dp_calle_pertenece_id);
        $this->assertEquals(121, $resultado->dp_pais_id);
        $this->assertEquals(1, $resultado->dp_estado_id);
        $this->assertEquals(1, $resultado->dp_municipio_id);
        $this->assertEquals(1, $resultado->dp_cp_id);
        $this->assertEquals(1, $resultado->dp_colonia_postal_id);

        errores::$error = false;
    }





}

