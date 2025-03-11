<?php 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

    $app->post('/llamardepartamentos', function(Request $request, Response $response){
        global $header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $stmt = $mysqli->prepare("CALL ver_departamentos()");
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    $app->post('/llamarmunicipios', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $stmt = $mysqli->prepare("CALL ver_municipios(?)");
        $stmt->bind_param("s", $datos->id_departamento);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    $app->post('/llamar_servicios', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $departamento = $datos->departamento;
        $municipio = $datos->municipio;
        $sede_usuario = $datos->sede;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $stmt = $mysqli->prepare("CALL ver_servicios(?,?,?)");
        $stmt->bind_param("sss", $departamento, $municipio, $sede_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    $app->post('/llamar_servicios_todos', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $stmt = $mysqli->prepare("CALL ver_servicios_todos()");
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    $app->post('/servicios_por_sede', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $departamento = $header['departamento'];
        $municipio = $header['municipio'];
        $sede_usuario = $header['sede_usuario'];
        // $arrayheader = explode(" ", $header['Authorization']);
        // $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $stmt = $mysqli->prepare("CALL ver_servicio_por_sede(?,?,?)");
        $stmt->bind_param("sss",$departamento, $municipio, $sede_usuario );
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    $app->post('/llamar_modulos', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $stmt = $mysqli->prepare("CALL ver_modulos()");
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    $app->post('/llamar_sedes_totales', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $stmt = $mysqli->prepare("CALL ver_sedes_totales()");
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    
    $app->post('/llamar_sedes', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $stmt = $mysqli->prepare("CALL ver_sedes(?,?)");
        $stmt->bind_param("ss", $datos->departamento, $datos->municipio);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    $app->post('/llamar_usuarios', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $arrayheader = explode(" ", $header['Authorization']);
        $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
        $stmt = $mysqli->prepare("CALL ver_usuarios()");
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
        $app->post('/agregar_servicios', function(Request $request, Response $response){
            global $datos,$header, $mysqli;
            $arrayheader = explode(" ", $header['Authorization']);
            $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
            $stmt = $mysqli->prepare("CALL insertar_servicio(?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssss", $datos->nombre, $datos->color, $datos->icono, $datos->inicial, $datos->departamento, $datos->municipio, $datos->sede);
            $stmt->execute();
            $result = $stmt->get_result();
            $response = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($response);
        });
        $app->post('/agregar_modulos', function(Request $request, Response $response){
            global $datos,$header, $mysqli;
            $arrayheader = explode(" ", $header['Authorization']);
            $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
            $stmt = $mysqli->prepare("CALL insertar_modulo(?,?)");
            $stmt->bind_param("ss", $datos->nombre, $datos->codigo);
            $stmt->execute();
            $result = $stmt->get_result();
            $response = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($response);
        });
        $app->post('/agregar_sedes', function(Request $request, Response $response){
            global $datos,$header, $mysqli;
            $arrayheader = explode(" ", $header['Authorization']);
            $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
            $stmt = $mysqli->prepare("CALL insertar_sede(?,?,?)");
            $stmt->bind_param("sss", $datos->nombre, $datos->departamento,$datos->municipio);
            $stmt->execute();
            $result = $stmt->get_result();
            $response = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($response);
        });
        $app->post('/ver_graficos', function(Request $request, Response $response){
            global $datos,$header, $mysqli;
            $arrayheader = explode(" ", $header['Authorization']);
            $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
            $stmt = $mysqli->prepare("CALL ver_graficos(?,?,?,?,?)");
            $stmt->bind_param("sssss", $datos->accion,$datos->fechainicial, $datos->fechafinal,$datos->departamentoreporte, $datos->municipioreporte);
            $stmt->execute();
            $result = $stmt->get_result();
            $response = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($response);
        });

        $app->post('/buscarautoafiliado', function(Request $request, Response $response){
            global $datos,$header, $mysqli;
            $ejecutar = $mysqli->prepare("CALL buscar_cliente_turno(?)");
            $ejecutar->bind_param("s", $datos->documento);
            $ejecutar->execute();
            $ejecutar -> store_result();
            $ejecutar -> bind_result($datosalida);
            $ejecutar -> fetch();
            echo $datosalida;
        });