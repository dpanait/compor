<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class HomeController extends Controller {
    public function index(){

        View::addCss('/libjs/jquery/bootstrap.min.css');
        View::addJs('/libjs/jquery/bootstrap.bundle.min.js');

        View::render('home', [], 'index');
    }
}