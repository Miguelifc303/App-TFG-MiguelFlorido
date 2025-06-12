<?php
include("db.php");
include("controller.php");

$cliente_id = $_POST["cliente"];
$mecanico_id = $_POST["mecanico"];
$marca = $_POST["marca"];
$modelo = $_POST["modelo"];
$matricula = $_POST["matricula"];
$anio_vehiculo = $_POST["anio_vehiculo"];
$fecha = $_POST["fecha"];
$estado_cita = $_POST["estado"];
$descripcion_cliente = $_POST["descripcion_cliente"];


//Buscar vehículo solo por matrícula
$stmt = $mysqli->prepare("SELECT id FROM vehiculos WHERE matricula = ?");
$stmt->bind_param("s", $matricula);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id_vehiculo);
    $stmt->fetch();
} else {
    $stmt->close();
    // Insertar vehículo nuevo
    $stmt = $mysqli->prepare("INSERT INTO vehiculos (marca, modelo, año, matricula) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $marca, $modelo, $anio_vehiculo, $matricula);
    $stmt->execute();
    $id_vehiculo = $stmt->insert_id;
}
$stmt->close();

//Verificar que la relación cliente-vehículo exista en clientes_vehiculos
$stmt = $mysqli->prepare("SELECT 1 FROM clientes_vehiculos WHERE id_cliente = ? AND id_vehiculo = ?");
$stmt->bind_param("ii", $cliente_id, $id_vehiculo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    $stmt->close();
    $stmt = $mysqli->prepare("INSERT INTO clientes_vehiculos (id_cliente, id_vehiculo) VALUES (?, ?)");
    $stmt->bind_param("ii", $cliente_id, $id_vehiculo);
    $stmt->execute();
}
$stmt->close();

//Insertar cita
$datos_cita = [
    "id_cliente" => $cliente_id,
    "id_vehiculo" => $id_vehiculo,
    "id_mecanico" => $mecanico_id,
    "fecha" => $fecha,
    "descripcion_cliente" => $descripcion_cliente,
    "estado_cita" => $estado_cita,
];

// Insertar cita con saveV
saveV("citas", $datos_cita);

header("Location: modulo_citas_list.php");
exit;
?>
