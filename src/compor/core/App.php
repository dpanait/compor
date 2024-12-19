<?php

namespace Core;

use Core\Exceptions\RouteNotFoundException;
use Core\Router;
use Core\Container;
use Core\View;
use Exception;

class App{

  protected $router;
  protected $request;
  public static Container $container;

  public function __construct(Container $container, Router $router, array $request){
    static::$container = $container;
    $this->router = $router;
    $this->request = $request;
    $droot = $container->resolve('droot');
    View::$droot = $droot;
    View::$base_path = "{$droot}public";

    if(App::resolve("environment") == "pro"){

      $version = file_get_contents('https://buygest.kuuvoo.com/dev/version_avanzado.txt');
      App::setService('version', $version);
      App::setService('url_api', "https://buygest.kuuvoo.com/pro/buy{$version}/yuubbbshop/data_fichar");

    }
  }

  public function run(){

    try{

      $method = $_SERVER['REQUEST_METHOD'];
      //var_dump($this->router->routes);
      $path = parse_url($this->request['uri'], PHP_URL_PATH);
      if(!isset($this->router->routes[$method][$path])){
        //new Exception("Error Processing Request", 1);
        throw new RouteNotFoundException("Route not found: " . $path, 404);
      }
      $this->router->handleRequest($path);
    } catch (RouteNotFoundException $e){
      http_response_code(404);

      if (static::$container->resolve("environment") !== "pro") {
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<p>File: " . $e->getFile() . "</p>";
        echo "<p>Line: " . $e->getLine() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
        echo "App";
      }
      View::render('error/404');


    } catch (\Exception $e) { // Catch other potential exceptions
      http_response_code(500); // Internal Server Error
      error_log("Unexpected error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());

      if (static::$container->resolve("environment") !== "pro") {
          echo "<h1>Unexpected Error:</h1>";
          echo "<p>" . $e->getMessage() . "</p>";
          echo "<p>File: " . $e->getFile() . "</p>";
          echo "<p>Line: " . $e->getLine() . "</p>";
          echo "<pre>" . $e->getTraceAsString() . "</pre>";
      } else {
          View::render('error/500'); // Render a generic 500 error page
      }
    }
  }
  public static function setContainer(Container $container){
    self::$container = $container;
  }
  public static function setService($key, $value){
    static::$container->setService($key, $value);
  } 
  public static function resolve($key){
    return static::$container->resolve($key);
  }
  public function obtenerRutaRaiz($ruta) {
    $rutaLimpia = trim($ruta, "/"); // Elimina las barras diagonales del principio y del final
    echo $rutaLimpia;
    $droot = trim($this->container->resolve('droot'), "/");

    if ($rutaLimpia === $droot) { // Comprueba si es "timecontrol" después de eliminar las barras
        return "/";
    } else if ($rutaLimpia === "") { // Maneja rutas vacías o solo con barras
        return "/";
    } else {
        return "/" . $rutaLimpia; // Añade una barra al principio en otros casos
    }
}
}