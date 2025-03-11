<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app->post('/ver_cantidad_turnos', function(Request $request, Response $response){
    global $header, $mysqli;
    $departamento = $header['departamento'];
    $municipio = $header['municipio'];
    $sede_usuario = $header['sede_usuario'];
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $stmt = $mysqli->prepare("CALL ver_total_turnos(?,?,?)");
    $stmt->bind_param("sss",$departamento,$municipio,$sede_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});
$app->post('/detalleturnos', function(Request $request, Response $response){
    global $header, $mysqli;
    $departamento = $header['departamento'];
    $municipio = $header['municipio'];
    $sede_usuario = $header['sede_usuario'];
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $stmt = $mysqli->prepare("CALL ver_detalle_turnos(?,?,?)");
    $stmt->bind_param("sss",$departamento,$municipio,$sede_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});
$app->post('/llamarturno', function(Request $request, Response $response){
    global $datos, $header, $mysqli;
    $servicio = $header['servicio'];
    $servicio_2 = $header['servicio_2'];
    $documento = $header['documento'];
    $modulo = $header['modulo'];
    $v_accion = $datos->v_accion;
    $departamento = $header['departamento'];
    $municipio = $header['municipio'];
    $sede_usuario = $header['sede_usuario'];
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $stmt = $mysqli->prepare("CALL llamar_turno(?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssss",$servicio,$servicio_2,$documento,$modulo,$v_accion,$departamento,$municipio,$sede_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});
$app->post('/llamardenuevo', function(Request $request, Response $response){
    global $datos, $header, $mysqli;
    $iddelturno = $datos->numerodeturno;
    $departamento = $header['departamento'];
    $municipio = $header['municipio'];
    $sede_usuario = $header['sede_usuario'];
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $stmt = $mysqli->prepare("CALL llamardenuevoturnotv(?,?,?,?)");
    $stmt->bind_param("ssss",$iddelturno,$departamento,$municipio,$sede_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});
$app->post('/soltar_turno', function(Request $request, Response $response){
    global $datos, $header, $mysqli;
    $iddelturno = $datos->numerodeturno;
    $departamento = $header['departamento'];
    $municipio = $header['municipio'];
    $sede_usuario = $header['sede_usuario'];
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $stmt = $mysqli->prepare("CALL soltar_turno(?,?,?,?)");
    $stmt->bind_param("ssss",$iddelturno,$departamento,$municipio,$sede_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});
$app->post('/redirigirelturno', function(Request $request, Response $response){
    global $datos, $header, $mysqli;
    $datoturno = $datos->v_datos_turno;
    $numero = $datoturno->numero;
    $turno = $datoturno->turno;
    $servicio = $header['servicio'];
    $documento = $header['documento'];
    $servicio_seleccionado = $datos->v_servicio_seleccionado;
    $departamento = $header['departamento'];
    $municipio = $header['municipio'];
    $sede_usuario = $header['sede_usuario'];
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $stmt = $mysqli->prepare("CALL redirigir_turno(?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssss",$numero,$turno,$servicio,$documento,$servicio_seleccionado,$departamento,$municipio,$sede_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});
$app->post('/llamarprioridad', function(Request $request, Response $response){
    global $datos, $header, $mysqli;
    $servicio = $header['servicio'];
    $servicio_2 = $header['servicio_2'];
    $documento = $header['documento'];
    $modulo = $header['modulo'];
    $v_accion = $datos->v_accion;
    $departamento = $header['departamento'];
    $municipio = $header['municipio'];
    $sede_usuario = $header['sede_usuario'];
    $arrayheader = explode(" ", $header['Authorization']);
    $validatoken = call_user_func('validar_token_inicio', $header['usuario'], $arrayheader[1]);
    $stmt = $mysqli->prepare("CALL llamar_turno_prioridad(?,?,?,?,?,?,?,?)");
    $stmt->bind_param("ssssssss",$servicio,$servicio_2,$documento,$modulo,$v_accion,$departamento,$municipio,$sede_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $response = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($response);
});

$app->post('/pantalladepartamentos', function(Request $request, Response $response){
        global $mysqli;
        $stmt = $mysqli->prepare("CALL ver_departamentos()");
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
$app->post('/pantallamunicipios', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $stmt = $mysqli->prepare("CALL ver_municipios(?)");
        $stmt->bind_param("s", $datos->id_departamento);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    $app->post('/pantalla_sedes', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $stmt = $mysqli->prepare("CALL ver_sedes(?,?)");
        $stmt->bind_param("ss", $datos->departamento, $datos->municipio);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });

    $app->post('/pantallatv', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $departamento = $header['departamento'];
        $municipio = $header['municipio'];
        $sede_usuario = $header['sede_usuario'];
        $stmt = $mysqli->prepare("CALL ver_turnos_pantalla(?,?,?)");
        $stmt->bind_param("sss", $departamento, $municipio, $sede_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    $app->post('/verelturnotv', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $departamento = $header['departamento'];
        $municipio = $header['municipio'];
        $sede_usuario = $header['sede_usuario'];
        $stmt = $mysqli->prepare("CALL llamar_turno_pantalla(?,?,?)");
        $stmt->bind_param("sss", $departamento, $municipio, $sede_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });
    $app->post('/terminarllamadopantalla', function(Request $request, Response $response){
        global $datos,$header, $mysqli;
        $iddelturno = $datos;
        $departamento = $header['departamento'];
        $municipio = $header['municipio'];
        $sede_usuario = $header['sede_usuario'];
        $stmt = $mysqli->prepare("CALL finalizar_turno_pantalla(?,?,?,?)");
        $stmt->bind_param("ssss",$iddelturno, $departamento, $municipio, $sede_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $response = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode($response);
    });