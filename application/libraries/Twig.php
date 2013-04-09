<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . "/core/Twig/Core_Twig_Extension.php";

use \Twig_Loader_Filesystem;
use \Twig_Environment;
use core\Twig\Core_Twig_Extension;

class Twig {

    protected $twig;

    public function __construct() {
        $loader = new Twig_Loader_Filesystem(APPPATH . "views/");
        $autoReload = false;
        $strictVariables = false;
        switch (ENVIRONMENT) {
            case 'development':
                $autoReload = true;
                $strictVariables = true;
                break;
            case 'production':
                $autoReload = false;
                $strictVariables = false;
                break;
        }
        $this->twig = new Twig_Environment($loader, array(
            'cache' => APPPATH . "cache/twig",
            'auto_reload' => $autoReload,
            'strict_variables' => $strictVariables
        ));
        $this->twig->addExtension(new Core_Twig_Extension());
        $this->twig->addExtension(new Twig_Extension_Debug());
    }

    public function render($view, array $vars, array $context = null) {
        return $this->twig->render($view, $vars);
    }

}