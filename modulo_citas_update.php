<?php
include("db.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $solicitud_id = $_POST['solicitud_id'];
    $fecha = $_POST['fecha'];
    $descripcion_cliente = $_POST['descripcion_cliente'];

    if (!empty($solicitud_id) && !empty($fecha) && !empty($descripcion_cliente)) {
        $query = "UPDATE solicitudes_cita 
          SET fecha_solicitada = ?, descripcion_cliente = ? 
          WHERE id = ?";

        if ($stmt = mysqli_prepare($mysqli, $query)) {
            mysqli_stmt_bind_param($stmt, "ssi", $fecha, $descripcion_cliente, $solicitud_id);

            if (mysqli_stmt_execute($stmt)) {
                // Si la actualización fue exitosa, redirigir a la lista de citas
                header("Location: modulo_citas_list.php");
                exit();
            } else {
                echo "Error al actualizar la solicitud.";
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error en la consulta: " . mysqli_error($mysqli);
        }
    } else {
        echo "Todos los campos son requeridos.";
    }
}
?>
