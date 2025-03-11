<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->post('/buscarcliente', function(Request $request, Response $response){
    global $datos,$header, $mysqli;
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $stmt = $mysqli->prepare("CALL buscar_cliente(?)");
    $stmt->bind_param("s", $datos->cedulaonombre);
    $stmt->execute();
    $result = $stmt->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});

$app->post('/registrarcliente', function(Request $request, Response $response){
    global $datos,$header, $mysqli;
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $ejecutar = $mysqli->prepare("CALL insertar_cliente(?,?,?,?,?,?,?,?)");
    $ejecutar->bind_param("ssssssss", $datos->documento,$datos->numero, $datos->pnombre,$datos->snombre, $datos->papellido,$datos->sapellido, $datos->celular,$datos->estado);
    $ejecutar->execute();
    $ejecutar -> store_result();
    $ejecutar -> bind_result($datosalida);
    $ejecutar -> fetch();
    $data = $datosalida;
    echo $data;
});

$app->post('/editarcliente', function(Request $request, Response $response){
    global $datos,$header, $mysqli;
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $ejecutar = $mysqli->prepare("CALL actualizar_cliente(?,?,?,?,?,?,?,?)");
    $ejecutar->bind_param("ssssssss", $datos->documento,$datos->numero, $datos->pnombre,$datos->snombre, $datos->papellido,$datos->sapellido, $datos->celular,$datos->estado);
    $ejecutar->execute();
    $ejecutar -> store_result();
    $ejecutar -> bind_result($datosalida);
    $ejecutar -> fetch();
    $data = $datosalida;
    echo $data;
});


$app->post('/clientes/cambiarestado', function(Request $request, Response $response){
    global $datos,$header, $mysqli;
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $ejecutar = $mysqli->prepare("CALL actualizarestadocliente(?,?)");
    $ejecutar->bind_param("ss", $datos->cliente,$datos->estado);
    $ejecutar->execute();
    $ejecutar -> store_result();
    $ejecutar -> bind_result($datosalida);
    $ejecutar -> fetch();
    $data = $datosalida;
    echo $data;
});