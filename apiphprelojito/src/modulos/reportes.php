<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;



$app->get('/ver_conteo_sedes', function(Request $request, Response $response){
    global  $mysqli,$header;
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $ejecutar = $mysqli->prepare("CALL ver_conteo_turnos_sedes()");
    $ejecutar->execute();
    $result = $ejecutar->get_result();
    $respuesta = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($respuesta);
});
$app->get('/ver_conteo_total', function(Request $request, Response $response){
    global  $mysqli,$header;
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $ejecutar = $mysqli->prepare("CALL ver_conteo_total()");
    $ejecutar->execute();
    $result = $ejecutar->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});

$app->post('/descargar_report', function(Request $request, Response $response){
    global $datos, $mysqli,$header;
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $ejecutar = $mysqli->prepare("CALL descargar_datos_turnos(?,?,?,?,?,?)");
    $ejecutar->bind_param("ssssss",$datos->fechainicial,$datos->fechafinal,$datos->departamentoreporte,$datos->municipioreporte,$datos->usuario,$datos->accion);
    $ejecutar->execute();
    $result = $ejecutar->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});

$app->post('/ver_graficos_servicios', function(Request $request, Response $response){
    global $datos, $mysqli,$header;
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $ejecutar = $mysqli->prepare("CALL ver_reporte_servicio(?,?,?)");
    $ejecutar->bind_param("sss",$datos->fechainicial,$datos->fechafinal,$datos->accion);
    $ejecutar->execute();
    $result = $ejecutar->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});