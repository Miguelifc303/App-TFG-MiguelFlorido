<?php
include("controller.php");
$tabla="usuarios";


$datos["id_rol"]=$_POST["id_rol"];
$datos["nombre"]=$_POST["nombre"];
$datos["email"]=$_POST["email"];
$datos["telefono"]=$_POST["telefono"];

$pass_Ant=conseguirValor($tabla,"password",$_POST["id"]);

if($pass_Ant!=$_POST["password"])
    $datos["password"]=md5($_POST["password"]);

echo updateById($tabla,$datos,$_POST["id"])
?>