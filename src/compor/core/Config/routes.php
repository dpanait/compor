<?php

use Core\App;
use Core\Router;
use Core\Container;
use Core\View;


$container = new Container();
$container->setService('droot', '/compor/');
$container->setService('environment', 'pre');

//echo $container->get('droot');
ini_set('session.gc_maxlifetime', 3600 * 24); // 1 hora
session_set_cookie_params(3600 * 24);
session_start();

// Crear el enrutador
$router = new Router();

// Rutas
$router->addRoute('GET', $container->resolve("droot"), [LoginController::class, 'index']);
$router->addRoute('POST', $container->resolve("droot"). 'login/authenticate', [LoginController::class, 'authenticate']);
$router->addRoute('GET', $container->resolve("droot"). 'login/logout', [LoginController::class, 'logout']);
$router->addRoute('GET', $container->resolve("droot").'about', function($container) {
  View::render('about');
});
//$router->addRoute('GET', $container->resolve("droot").'workday', [WorkdayController::class, 'index']);
$router->addRoute('GET', $container->resolve("droot").'home', [HomeController::class, 'index']);
$router->addRoute('GET', $container->resolve("droot").'about', [AboutController::class, 'index']);

$container->setService(Router::class, function () {
  return new Router(); // Asegúrate de que Router reciba el contenedor si lo necesita
});

// Rutas a los archivos existentes (CSS, JS, imágenes, etc.)
/*if (php_sapi_name() === 'cli-server') {
  $filePath = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  if (is_file($filePath)) {
      return false; // Sirve el archivo directamente
  }
}*/

(new App(
  $container,
  $router,
  ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]
))->run();