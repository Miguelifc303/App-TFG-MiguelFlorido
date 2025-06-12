<?php
//Funciones para chart.js
function getClientesPorMes() {
    include("db.php");

    $sql = "SELECT 
          mes,
          COUNT(DISTINCT id_cliente) AS total
        FROM (
          SELECT DATE_FORMAT(fecha_solicitada, '%Y-%m') AS mes, id_cliente
          FROM solicitudes_cita
          WHERE fecha_solicitada >= DATE_SUB(NOW(), INTERVAL 12 MONTH)

          UNION ALL

          SELECT DATE_FORMAT(fecha, '%Y-%m') AS mes, id_cliente
          FROM citas
          WHERE fecha >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        ) AS union_fechas
        GROUP BY mes
        ORDER BY mes ASC
    ";

    $query = $mysqli->query($sql);
    $datos = [];

    if ($query) {
        while ($fila = $query->fetch_assoc()) {
            $datos[] = $fila;
        }
    }

    return $datos;
}

 function getCitasPorMecanico() {
    include("db.php");
    $sql = "SELECT 
                u.nombre AS mecanico,
                COUNT(*) AS total_citas
            FROM citas c
            LEFT JOIN usuarios u ON c.id_mecanico = u.id
            WHERE u.id_rol = 3
            GROUP BY c.id_mecanico
            ORDER BY total_citas DESC";

    $query = $mysqli->query($sql);
    $datos = [];

    while ($fila = $query->fetch_assoc()) {
        $datos[] = $fila;
    }

    return $datos;
}



?>