<?php
$host="localhost:3306";
$user="root";
$password="";
$database="bd_taller_mecanica";

$mysqli=new mysqli($host, $user, $password , $database);

if(mysqli_connect_errno()){
    printf("Falló la conexion:
    %s\n" ,$mysqli->connect_error);
    exit();
}
$mysqli->set_charset("utf8");
?>