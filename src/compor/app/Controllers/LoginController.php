<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Core\Router;
use App\Libraries\Service;
use Core\App;

class LoginController extends Controller {

  public function index(){
    $error = "";
    if(isset($_GET['error'])){
      $error = $_GET['error'];
    }

    $data = [
        'title' => 'Inicio de Sesión',
        'description' => 'Por favor, ingresa tus credenciales.',
        'error' => $error
    ];

    View::addCss('/libjs/jquery/bootstrap.min.css');
    View::addCss('/libjs/jquery/font/font//bootstrap-icons.min.css');
    View::addCss('/css/login.css');
    View::addJs('/libjs/qrcode/html5-qrcode.js');
    View::render('login', $data, 'login');
  }
  public function authenticate() {
    // Simulación: Reemplaza esto con la validación real de credenciales
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username == "admin" && $password == 'admin') {
    
      $this->router->redirect($this->droot . 'home');

    } else {
      // Redirige de vuelta al login con un mensaje de error
      $this->router->redirect($this->droot . '?error=No se ha igresado nungun codígo');
    }
  }
  public function logout() {

    if (session_status() === PHP_SESSION_ACTIVE) {
      session_destroy(); // Elimina todos los datos de sesión

      // Redirige al login
      $this->router->redirect("{$this->droot}");
    }
  }
}