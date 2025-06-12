<?php
include("controller.php");
session_start(); // Asegurar que la sesión inicie correctamente

$username = trim($_POST["username"]); // Elimina espacios en blanco
$pass = md5($_POST["password"]);

$fila = VerificarUsuario($username, $pass);

if ($fila != 0) {
    $_SESSION["id_roles"] = $fila["id_rol"];
    $_SESSION["role"] = getById("roles", $fila["id_rol"])["rol"];
    $_SESSION["id_usuario"] = $fila["id"];
    $_SESSION["usuario"] = $fila["nombre"];
    $_SESSION["email"] = $fila["email"];
    $_SESSION["valido"] = "1";

    echo 1;
} else {
    echo 0;
}
?>
