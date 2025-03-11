<?php
function validar_token_inicio($usuario,$token){
    global  $mysqli;
    $ejecutar = $mysqli->prepare("CALL validar_token(?,?)");
    $ejecutar->bind_param("ss",$token,$usuario);
    $ejecutar->execute();
    $ejecutar -> store_result();
        $ejecutar -> bind_result($datosalida);
        $ejecutar -> fetch();
        $datosal = $datosalida;
        if($datosal != 200){
        echo http_response_code($datosal);
        die();
        }
}