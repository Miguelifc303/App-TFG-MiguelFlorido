<?php
session_unset();    // Elimina todas las variables de sesión
session_destroy();  // Destruye la sesión

// Redirigir a la página de login o inicio
header("Location: login.php");
exit();
?>
