<?php

namespace Core\Exceptions;

class RouteNotFoundException extends \Exception{
  protected $message = "404 Not Found";
  // Opcional: Propiedades adicionales
  protected $route;

  // Constructor (opcional)
  public function __construct($message = "Route not found", $code = 404, Exception $previous = null, $route = null)
  {
      parent::__construct($message, $code, $previous); // Llamamos al constructor de la clase padre Exception
      $this->route = $route; // Guardamos la ruta que no se encontró
  }

  // Opcional: Métodos getter para las propiedades adicionales
  public function getRoute()
  {
      return $this->route;
  }

  // Opcional: Redefinir el método __toString() para un formato de salida personalizado
  public function __toString()
  {
      return __CLASS__ . ": [{$this->code}]: {$this->message} (Route: {$this->route})\n";
  }
}
