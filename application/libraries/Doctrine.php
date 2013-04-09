<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\Common\ClassLoader;

class Doctrine {

    public $em = null;

    public function __construct() {
        // load database configuration from CodeIgniter
        require_once APPPATH . 'config/database.php';
        $path = array(APPPATH . "models/Entity");
        $isDevMode = false;
        switch (ENVIRONMENT) {
            case 'development':
                $isDevMode = true;
                break;
            case 'production':
                $isDevMode = false;
                break;
        }
        $entitiesClassLoader = new ClassLoader('models', rtrim(APPPATH, "/"));
        $entitiesClassLoader->register();
        // the connection configuration
        $dbParams = array(
            'driver' => $db['default']['dbdriver'],
            'user' => $db['default']['username'],
            'password' => $db['default']['password'],
            'host' => $db['default']['hostname'],
            'dbname' => $db['default']['database']
        );
        $config = Setup::createAnnotationMetadataConfiguration($path, $isDevMode);
        // Create EntityManager
        $this->em = EntityManager::create($dbParams, $config);
    }

}