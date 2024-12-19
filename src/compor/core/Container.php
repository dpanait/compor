<?php

namespace Core;

class Container{
  protected $services = [];
  // Método para registrar un servicio en el contenedor
  public function setService($name, $service) {
    $this->services[$name] = $service;
  }

  // Método para obtener un servicio del contenedor
  public function resolve($name) {
    if (!isset($this->services[$name])) {
      throw new \Exception("Service not found: " . $name);
    }
    // Si el servicio es una función anónima, lo invocamos
    if (is_callable($this->services[$name])) {
      return $this->services[$name]($this);
    }
    
    // Si es una clase, la devolvemos directamente
    return $this->services[$name];
  }
}