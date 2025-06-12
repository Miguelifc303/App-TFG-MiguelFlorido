<?php
include("controller.php");
$tabla="usuarios";

$datos["id_rol"] = $_POST["id_rol"];
$datos["nombre"] = $_POST["nombre"];
$datos["email"] = $_POST["email"];
$datos["password"] = md5($_POST["password"]);
$datos["telefono"] = $_POST["telefono"];

echo saveV($tabla, $datos);
?>
