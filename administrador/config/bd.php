<?php

$host="localhost";
$bd="TallerSO";
$usuario="root";
$contrasenia="";

        try {

            $conexion=new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasenia);
            //if($conexion){ echo "Conexion exitosa";}

        } catch ( Exception $ex) {

            echo $ex->getMessage();

        }
?>