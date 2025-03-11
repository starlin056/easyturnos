<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/buscarclienteturno', function(Request $request, Response $response){
    global $datos,$header, $mysqli;
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $ejecutar = $mysqli->prepare("CALL buscar_cliente_turno(?)");
    $ejecutar->bind_param("s", $datos->cedulaonombre);
    $ejecutar->execute();
    $ejecutar -> store_result();
    $ejecutar -> bind_result($datosalida);
    $ejecutar -> fetch();
    echo $datosalida;
});
$app->post('/generarturno', function(Request $request, Response $response){
    global $datos,$header, $mysqli;
    $departamento = $header['departamento'];
    $municipio = $header['municipio'];
    $sede_usuario = $header['sede_usuario'];
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $ejecutar = $mysqli->prepare("CALL generar_turno(?,?,?,?,?,?,?,?,?,?)");
    $ejecutar->bind_param("ssssssssss", $datos->accion,$datos->tipodocumento,$datos->datosclientepnombre,$datos->datosclientepapellido,$datos->tipotramite, $datos->letrainicial, $datos->numero_doc, $departamento, $municipio, $sede_usuario);
    $ejecutar->execute();
    $ejecutar -> store_result();
    $ejecutar -> bind_result($datosalida);
    $ejecutar -> fetch();
    echo $datosalida;
});
$app->post('/generarautoturno', function(Request $request, Response $response){
    global $datos,$header, $mysqli;
    $departamento = $header['departamento'];
    $municipio = $header['municipio'];
    $sede_usuario = $header['sede_usuario'];
    $ejecutar = $mysqli->prepare("CALL generar_turno_auto(?,?,?,?,?,?,?,?,?,?)");
    $ejecutar->bind_param("ssssssssss",$datos->registrarcliente, $datos->tipotramite, $datos->letrainicial, $datos->tipodocumento,$datos->numero_doc, $datos->pnombre,$datos->papellido, $departamento, $municipio, $sede_usuario);
    $ejecutar->execute();
    $ejecutar -> store_result();
    $ejecutar -> bind_result($datosalida);
    $ejecutar -> fetch();
    echo $datosalida;
});