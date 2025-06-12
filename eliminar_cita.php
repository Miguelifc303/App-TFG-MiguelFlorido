<?php
session_start();
include("db.php");

if (isset($_GET['id'])) {
    $id_cita = intval($_GET['id']);
    $id_usuario = $_SESSION['id_usuario'];

    // Verificar que la cita exista y pertenezca al usuario
    $stmt = $mysqli->prepare("SELECT id_solicitud FROM citas WHERE id = ? AND id_mecanico = ?");
    $stmt->bind_param("ii", $id_cita, $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "No tienes permiso para eliminar esta cita o no existe.";
        exit();
    }

    // Obtener id_solicitud antes de eliminar la cita
    $row = $result->fetch_assoc();
    $id_solicitud = $row['id_solicitud'];

    // Iniciar transacción
    $mysqli->begin_transaction();

    try {
        // Eliminar cita
        $stmt_del_cita = $mysqli->prepare("DELETE FROM citas WHERE id = ?");
        $stmt_del_cita->bind_param("i", $id_cita);
        $stmt_del_cita->execute();

        // Eliminar solicitud asociada, si existe
        if (!empty($id_solicitud)) {
            $stmt_del_solicitud = $mysqli->prepare("DELETE FROM solicitudes_cita WHERE id = ?");
            $stmt_del_solicitud->bind_param("i", $id_solicitud);
            $stmt_del_solicitud->execute();
        }

        // Confirmar transacción
        $mysqli->commit();

        // Redirigir
        header("Location: modulo_citas_asignadas_list.php");
        exit();
    } catch (Exception $e) {
        // Revertir si algo falla
        $mysqli->rollback();
        echo "Error al eliminar cita y solicitud: " . $e->getMessage();
    }
} else {
    echo "ID de cita no proporcionado.";
}
?>

