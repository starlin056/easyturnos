<?php
// SELECT CONVERT_TZ(NOW(), '+00:00', '-05:00');
date_default_timezone_set('America/Bogota');
  $mysqli = new mysqli("localhost", "root", "", "db_relojito");
  $mysqli->query("SET time_zone = '-05:00'");
 if ($mysqli->connect_errno) {
     printf("Falló la conexión: %s\n", $mysqli->connect_error);
     exit();
 } else {
    $mysqli->set_charset('utf8');
     return $mysqli;
 }

//  SET collation_connection = 'utf8mb4_spanish_ci';
// ALTER DATABASE u115535859_db_tuplaza CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
// ALTER TABLE modulos_db CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;
