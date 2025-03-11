<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


    $app->post('/registrarusuario', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
      $passwordencriptar = password_hash($datos->password, PASSWORD_BCRYPT, ['cost' => 12,]);
        global  $mysqli;
        $ejecutar = $mysqli->prepare("CALL insertar_usuario(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $ejecutar->bind_param("sssssssssssssssssss", $datos->usuario,$passwordencriptar,$datos->cedula,$datos->nombres,$datos->apellidos,$datos->celular,$datos->correo,$datos->departamento,$datos->municipio,$datos->barrio,$datos->direccion,$datos->estado,$datos->nivel,$datos->servicio_utilizar,$datos->cantidad_llamar_servicio1,$datos->servicio_2,$datos->cantidad_llamar_servicio2,$datos->modulo_utilizar,$datos->sede_usuario);
        $ejecutar->execute();
        $ejecutar -> store_result();
        $ejecutar -> bind_result($datosalida);
        $ejecutar -> fetch();
        $datos = $datosalida;
        echo $datos;
    });

    $app->post('/buscarusuario', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $stmt = $mysqli->prepare("CALL buscar_usuario(?)");
        $stmt->bind_param("s", $datos->cedulaonombre);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    
    $app->post('/editarusuario', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $ejecutar = $mysqli->prepare("CALL actualizar_usuario(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $ejecutar->bind_param("ssssssssssssssssss", $datos->usuario,$datos->cedula,$datos->nombres,$datos->apellidos,$datos->celular,$datos->correo,$datos->departamento,$datos->municipio,$datos->barrio,$datos->direccion,$datos->estado,$datos->nivel,$datos->servicio_utilizar,$datos->cantidad_llamar_servicio1,$datos->servicio_2,$datos->cantidad_llamar_servicio2,$datos->modulo_utilizar,$datos->sede_usuario);
        $ejecutar->execute();
        $ejecutar -> store_result();
        $ejecutar -> bind_result($datosalida);
        $ejecutar -> fetch();
        $datos = $datosalida;
        echo $datos;
    });

    $app->post('/actualizarestado', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $usuario = $datos->usuario;
        $estado = $datos->estado;
        $ejecutar = $mysqli->prepare("CALL actualizar_estado(?,?)");
        $ejecutar -> bind_param('ss', $usuario, $estado);
        $ejecutar -> execute();
        $ejecutar -> store_result();
        $ejecutar -> bind_result($datousuario);
        $ejecutar -> fetch();
        $datos = $datousuario;
        echo $datos;
    });

 
    $app->post('/cambioclave', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $passwordencriptar = password_hash($datos->clave, PASSWORD_BCRYPT, ['cost' => 12,]);
        $ejecutar = $mysqli->prepare("CALL actualizar_clave(?,?)");
        $ejecutar->bind_param("ss", $datos->usuario, $passwordencriptar);
        $ejecutar->execute();
        $ejecutar -> store_result();
        $ejecutar -> bind_result($datosalida);
        $ejecutar -> fetch();
        $data = $datosalida;
        echo $data;
    });
       