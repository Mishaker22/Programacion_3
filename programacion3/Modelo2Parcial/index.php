<?php
//include '../clases/usuario.php';
use \Firebase\JWT\JWT;
//Use App\Middlewares\AuthMiddleware;
Use App\Middlewares\JsonMiddleware;
Use App\Middlewares\TiposMiddleware;
//Use App\Middlewares\UserMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Exception\HttpNotFoundException;
use Slim\Middleware\ErrorMiddleware;
use App\Controller\UserController;
use Config\Database;

require __DIR__ . '/vendor/autoload.php';
$app = AppFactory::create();
$app->setBasePath("/programacion3/Modelo2Parcial");

//$app->addRoutingMiddleware();
new Database; 

$app->group('/users', function (RouteCollectorProxy $group) {
    $group->post('[/]', UserController::class .":Add")->add(new TiposMiddleware);
    $group->get('/{id}[/{edad}]', UserController::class .":GetOne");
    $group->get('[/]', UserController::class .":GetAll");
    $group->put('/{id}', UserController::Class .":Update");
    $group->delete('/{id}', UserController::class .":Delete"); 
});//->add(new UserMiddleware)->add(new AuthMiddleware);
//$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$app->post('[/login]', UserController::class .":GetOne");

$app->group('/materia', function (RouteCollectorProxy $group) {
    $group->post('[/]', UserController::class .":Add");
    $group->get('/{id}[/{edad}]', UserController::class .":GetOne");
    $group->get('[/]', UserController::class .":GetAll");
    $group->put('/{id}', UserController::Class .":Update");
    $group->delete('/{id}', UserController::class .":Delete"); 
});

$app->add(new JsonMiddleware);
$app->run();


?>