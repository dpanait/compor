<?php

namespace Core;
use Core\Router;
use Core\View;

class Controller{
  protected $droot = "";
  protected $router;

  // Inyectamos el contenedor de dependencias en el constructor
  public function __construct() {
    $this->router = App::resolve(Router::class);
    
    $droot = App::resolve('droot');
    $this->droot = $droot;
  }

  public function view($view, $data = []) {
    extract($data);
    require "../app/Views/$view.php";
  }
}