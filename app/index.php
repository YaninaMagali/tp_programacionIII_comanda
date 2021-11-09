<?php
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';
require_once './controller/EmpleadoController.php';
require_once './controller/MenuController.php';
require_once './controller/MesaController.php';
require_once './controller/PedidoController.php';
require_once './database/DAO.php';
require_once './errorLog.php';
// require_once './middleware/ComprobarAlgoMw.php';

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// peticiones
$app->group('/empleados', function (RouteCollectorProxy $group) {
    $group->get('[/]', \EmpleadoController::class . ':ListarEmpleados');
    $group->get('/{usuario}', \EmpleadoController::class . ':ObtenerEmpleado');
    $group->post('[/]', \EmpleadoController::class . ':CrearEmpleado');
    // $group->put('[/]', \UsuarioController::class . ':ModificarUno');
    // $group->delete('[{usuario/usuarioId}]', \UsuarioController::class . ':BorrarUno ')->add(\ComprobarAlgoMw::class . ':ComprobarNombreMw');
  });

$app->group('/menu', function (RouteCollectorProxy $group) {
  $group->get('[/]', \MenuController::class . ':ListarItemsMenu');
  //$group->get('/{usuario}', \EmpleadoController::class . ':ObtenerEmpleado');
  $group->post('[/]', \MenuController::class . ':CrearItemMenu');
  // $group->put('[/]', \UsuarioController::class . ':ModificarUno');
  // $group->delete('[{usuario/usuarioId}]', \UsuarioController::class . ':BorrarUno ')->add(\ComprobarAlgoMw::class . ':ComprobarNombreMw');
});

$app->group('/mesa', function (RouteCollectorProxy $group) {
  $group->get('[/]', \MesaController::class . ':ListarMesas');
  //$group->get('/{usuario}', \EmpleadoController::class . ':ObtenerEmpleado');
  $group->post('[/]', \MesaController::class . ':CrearMesa');
  // $group->put('[/]', \UsuarioController::class . ':ModificarUno');
  // $group->delete('[{usuario/usuarioId}]', \UsuarioController::class . ':BorrarUno ')->add(\ComprobarAlgoMw::class . ':ComprobarNombreMw');
});

$app->group('/pedido', function (RouteCollectorProxy $group) {
  //$group->get('[/]', \MesaController::class . ':ListarMesas');
  //$group->get('/{usuario}', \EmpleadoController::class . ':ObtenerEmpleado');
  $group->post('[/]', \PedidoController::class . ':CrearPedido')->add(\JsonBodyParserMiddleware::class . ':process');
  // $group->put('[/]', \UsuarioController::class . ':ModificarUno');
  // $group->delete('[{usuario/usuarioId}]', \UsuarioController::class . ':BorrarUno ')->add(\ComprobarAlgoMw::class . ':ComprobarNombreMw');
});

$app->run();
