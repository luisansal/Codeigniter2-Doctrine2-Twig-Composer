<?php
require_once "bootstrap.php";
require_once __DIR__ . "/application/libraries/Doctrine.php";
$doctrine = new Doctrine();
$helperSet = new Symfony\Component\Console\Helper\HelperSet(array(
            'em' => new Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($doctrine->em)
        ));
?>
