<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';
require '../src/config/validar_token.php';

$app = new \Slim\App;
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin,Authorization,usuario,documento,servicio,servicio_2,modulo,departamento,municipio,sede_usuario')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST');
});

$header = getallheaders();
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$datos = $request;
require '../src/modulos/loginusuarios.php';
require '../src/modulos/reportes.php';
require '../src/modulos/utilidades.php';
require '../src/modulos/usuarios.php';
require '../src/modulos/clientes.php';
require '../src/modulos/generarturno.php';
require '../src/modulos/atenderturnos.php';

$app->run();