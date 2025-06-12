<?php
$id = $_POST['id'];
$tipo = $_POST['tipo'] ?? '';

include("controller.php");
include("db.php");

if ($tipo === 'cita') {
    //Ver id_solicitud antes de borrar la cita
    $sql = "SELECT id_solicitud FROM citas WHERE id = '$id'";
    $result = $mysqli->query($sql);

    $id_solicitud = null;
    if ($result && $row = $result->fetch_assoc()) {
        $id_solicitud = $row['id_solicitud'];
    }

    //Borrar la cita
    $borrar_cita = delByIdCampo("citas", "id", $id);

    //Si tiene solicitud asociada, eliminar también
    if ($borrar_cita && !empty($id_solicitud)) {
        delByIdCampo("solicitudes_cita", "id", $id_solicitud);
    }

    echo ($borrar_cita) ? 1 : 0;

} elseif ($tipo === 'solicitud') {
    // Solo borrar la solicitud (cuando aún no hay cita asociada)
    echo delByIdCampo("solicitudes_cita", "id", $id);

} else {
    echo 0; 
}
?>
