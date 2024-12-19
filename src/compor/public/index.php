<?php
// Mostrar errores y advertencias
error_reporting(E_ALL);

// Activar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

//echo phpinfo();
$root = __DIR__ ."/../";//str_replace("public", "", __DIR__);
// echo $root,PHP_EOL;
// echo $root .'vendor/autoload.php';
require $root .'vendor/autoload.php';
require $root .'core/Config/routes.php';