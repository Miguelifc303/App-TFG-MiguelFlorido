<?php
include("controller.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_solicitud = $_POST['id_solicitud'];
    $mecanico_id = $_POST['mecanico_id'];

    // Aquí insertamos o actualizamos los datos de la cita, asignando el mecánico
    $asignacion_exito = asignarMecanicoACita($id_solicitud, $mecanico_id);  

    if ($asignacion_exito) {
        header("Location: modulo_citas_list.php");
        exit(); 
    } else {
        echo "Error al asignar el mecánico.";
    }
}
?>
