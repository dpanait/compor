<?php

namespace App\Libraries;

use Core\Container;

class Service {

  public function __construct() {
  }

  public function get_work_today($url, $code1){
    // Inicializa cURL
    $ch = curl_init();
    // Define los datos a enviar (por ejemplo, un array de parámetros)
    $data = array(
      'PostData' => array(
        'code1' => $code1,
        'action' => 'get_work_today',
       )
    );
    // Establece las opciones para la solicitud POST
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));//http_build_query
    // Ejecuta la solicitud
    $response = curl_exec($ch);
    // Verifica si hubo un error en la solicitud
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Muestra la respuesta
        //echo $response;
        return $response;
    }
  }

  public function check_login_code($url, $login_code){
    // Inicializa cURL
    $ch = curl_init();
    // Define los datos a enviar (por ejemplo, un array de parámetros)
    $data = array(
      'PostData' => array(
        'login_code' => $login_code,
        'action' => 'check_login_code',
       )
    );
    // Establece las opciones para la solicitud POST
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));//http_build_query
    // Ejecuta la solicitud
    $response = curl_exec($ch);
    // Verifica si hubo un error en la solicitud
    if(curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    } else {
        // Muestra la respuesta
        //echo $response;
        return $response;
    }
  }

}