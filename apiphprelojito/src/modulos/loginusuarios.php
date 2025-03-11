<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
$app->post('/login', function(Request $request, Response $response){
    global $datos, $mysqli;
    $ejecutar = $mysqli->prepare("CALL loginacceso(?)");
    $ejecutar->bind_param("s", $datos->usuario);
    $ejecutar->execute();
    $ejecutar -> store_result();
    $ejecutar -> bind_result($datosalida);
    $ejecutar -> fetch();
    $data = json_decode($datosalida);
    $datousuario = json_decode($data->DATOS);
    if (!empty($datousuario[0]->password)) {
            if (password_verify($datos->password, $datousuario[0]->password)) {
                mysqli_next_result($mysqli);
                $inserToken = insertartoken($datousuario[0]->usuario);
                $arrResponse = array('status' => true, 
                                    'token' => $inserToken,
                                    'nombres' => $datousuario[0]->nombres.' '.$datousuario[0]->apellidos,
                                    'usuario' => $datousuario[0]->usuario,
                                    'cedula' => $datousuario[0]->cedula,
                                    'servicio_utilizar' => $datousuario[0]->servicio_utilizar,
                                    'modulo_utilizar' => $datousuario[0]->modulo_utilizar,
                                    'departamento' => $datousuario[0]->departamento,
                                    'municipio' => $datousuario[0]->municipio,
                                    'sede_usuario' => $datousuario[0]->sede_usuario,
                                    'nombre_departamento' => $datousuario[0]->nombre_departamento,
                                    'nombre_municipio' => $datousuario[0]->nombre_municipio,
                                    'nombre_sede' => $datousuario[0]->nombre_sede,
                                    'nombre_servicio' => $datousuario[0]->nombre_servicio,
                                    'nombre_servicio2' => $datousuario[0]->nombre_servicio2,
                                    'nombre' => $datousuario[0]->nombre,
                                    'servicio_2' => $datousuario[0]->servicio_2,
                                    'cantidad_llamar_servicio1' => $datousuario[0]->cantidad_llamar_servicio1,
                                    'cantidad_llamar_servicio2' => $datousuario[0]->cantidad_llamar_servicio2,
                                    'cantidad_llamar_servicio1' => $datousuario[0]->cantidad_llamar_servicio1);

            } else {
                $arrResponse = array('status' => false, 'msg' => 'Usuario O Contraseña Ivalida');
            }
       
    } else {
        $arrResponse = array('status' => false, 'msg' => 'Usuario Invalido Intentelo Nuevamente');
    }

    echo json_encode($arrResponse);
});

function insertartoken($usuarioid)
{
    global  $mysqli;
    $r1 = bin2hex(random_bytes(10));
    $r2 = bin2hex(random_bytes(10));
    $r3 = bin2hex(random_bytes(10));
    $r4 = bin2hex(random_bytes(10));
    $token = $r1 . '-' . $r2 . '-' . $r3 . '-' . $r4;
    $myquery = $mysqli->prepare("CALL insertartokenlogin(?,?)");
        $myquery->bind_param("ss", $token,$usuarioid);
        $myquery->execute();
        $myquery -> store_result();
        $myquery -> bind_result($datosalida);
        $myquery -> fetch();
        $datos = $datosalida;
        $datosal = $datos;
    if ($datosal == 0) {
        return $token;
    } else {
        return false;
    }
}
