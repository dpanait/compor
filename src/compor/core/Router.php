<?php
namespace Core;

use Core\Exceptions\RouteNotFoundException;
use Core\App;

class Router
{
  public $routes = [];
  private $basePath = '';
  //protected $root= "";

  public function __construct() {

  }

  public function addRoute($method, $path, $handler)
  {
    $this->routes[$method][$path] = $handler;
  }

  public function handleRequest($uri)
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $path = parse_url($uri, PHP_URL_PATH);


    if (isset($this->routes[$method][$path])) {
        $handler = $this->routes[$method][$path];

        if (is_callable($handler)) {
            return $handler(); // Llama al closure si es una función anónima
        }

        if (is_array($handler) /*&& strpos($handler, '@') !== false*/) { // Verifica si es un string con @
            //[$controller, $methodName] = explode('@', $handler);
            $controller = $handler[0];
            $methodName = $handler[1];
            $controllerClass = "\\App\\Controllers\\" . $controller; // Namespace del controlador

            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                if (method_exists($controllerInstance, $methodName)) {
                    return $controllerInstance->$methodName();
                } else {
                    throw new RouteNotFoundException("Method '$methodName' not found in controller '$controller'.", 404);
                }
            } else {
                throw new RouteNotFoundException("Controller '$controller' not found.", 404);
            }
        }
    }

    throw new RouteNotFoundException("Route '$path' not found.", 404);
  }

  public function getBasePath() {
      return $this->basePath;
  }
  public function redirect($url, $statusCode = 302) {

    if(!headers_sent()){
      //echo $location;
      header('Location: ' . $url, true, $statusCode);
      exit;
    } else {
      echo "<script type='text/javascript'>";
      echo " window.location.href = '" . $url."';";
      echo "</script>";
      echo "<noscript>";
      echo "<meta http-equiv='refresh' content='0;url='".$url."' />";
      echo "</noscript>";
      exit;

    }
  }
}