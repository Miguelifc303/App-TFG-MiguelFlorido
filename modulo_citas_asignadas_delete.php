<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id_cita = intval($_POST['id']);
    $id_usuario = $_SESSION['id_usuario'];

    $stmt = $mysqli->prepare("SELECT id_solicitud FROM citas WHERE id = ? AND id_mecanico = ?");
    $stmt->bind_param("ii", $id_cita, $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo 0;
        exit();
    }

    $row = $result->fetch_assoc();
    $id_solicitud = $row['id_solicitud'];

    $mysqli->begin_transaction();
    try {
        $stmt_del_cita = $mysqli->prepare("DELETE FROM citas WHERE id = ?");
        $stmt_del_cita->bind_param("i", $id_cita);
        $stmt_del_cita->execute();

        if (!empty($id_solicitud)) {
            $stmt_del_solicitud = $mysqli->prepare("DELETE FROM solicitudes_cita WHERE id = ?");
            $stmt_del_solicitud->bind_param("i", $id_solicitud);
            $stmt_del_solicitud->execute();
        }

        $mysqli->commit();
        echo 1;
    } catch (Exception $e) {
        $mysqli->rollback();
        echo 0;
    }
} else {
    echo 0;
}
?>