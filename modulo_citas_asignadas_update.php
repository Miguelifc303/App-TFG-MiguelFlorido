<?php
include("db.php");

// Verificar que se haya recibido el ID de la cita y el veredicto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cita_id'], $_POST['veredicto_mecanico'])) {
    $cita_id = $_POST['cita_id'];
    $veredicto_mecanico = $_POST['veredicto_mecanico'];

    // Actualizar el veredicto del mecánico y cambiar el estado de la cita a 'Finalizada'
    $query_update_cita = "UPDATE citas SET veredicto_mecanico = ?, estado_cita = 'Finalizada' WHERE id = ?";
    if ($stmt = mysqli_prepare($mysqli, $query_update_cita)) {
        mysqli_stmt_bind_param($stmt, "si", $veredicto_mecanico, $cita_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: modulo_citas_asignadas_list.php");
        exit();
    } else {
        echo "Error al actualizar la cita.";
    }
} else {
    echo "Faltan parámetros.";
}
?>
