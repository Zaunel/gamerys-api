<?php
require_once 'libs/Router.php';
require_once 'Controllers/JuegosController.php';

$resource = $_GET["resource"];
$method = $_SERVER["REQUEST_METHOD"];

$router = new Router();

$router->addRoute('juegos', 'GET', 'JuegosController', 'asignarGet');
$router->addRoute('juego/:ID', 'GET', 'JuegosController', 'obtenerJuegos');
$router->addRoute('juegos', 'POST', 'JuegosController', 'agregarJuego');
$router->addRoute('juego/:ID', 'DELETE', 'JuegosController', 'borrarJuego'); 
$router->addRoute('juego/:ID', 'PUT', 'JuegosController', 'modificarJuego');
$router->addRoute('juegos', 'GET', 'JuegosController', 'asignarGet');
$router->addRoute('juegos', 'GET', 'JuegosController', 'asignarGet');
$router->route($resource,$method);

?>