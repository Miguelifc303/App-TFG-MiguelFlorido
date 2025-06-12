<?php 

include("db.php");
include("controllerClientes.php");

// Recibo datos del formulario
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$anio = $_POST['anio'];
$matricula = $_POST['matricula'];
$fecha_solicitada = $_POST['fecha_solicitada'];
$descripcion_cliente = $_POST['descripcion_cliente'];

// Validaciones
$errores = [];

if (empty($nombre) || empty($email) || empty($telefono) || empty($fecha_solicitada)) {
    $errores[] = "Todos los campos obligatorios deben estar rellenados.";
}

if (!validarTelefono($telefono)) {
    $errores[] = " Teléfono inválido. Debe tener 9 dígitos (se permiten espacios).";
}

if (!validarEmail($email)) {
    $errores[] = " Correo electrónico inválido.";
}

if (!validarMatricula($matricula)) {
    $errores[] = " Matrícula inválida. Debe tener entre 5 y 10 caracteres alfanuméricos (letras, números y guiones permitidos).";
}

if (!validarAnioVehiculo($anio)) {
    $errores[] = "Año del vehículo no válido.";
}

if (!validarFechaFutura($fecha_solicitada)) {
    $errores[] = "La fecha solicitada debe ser futura.";
}

if (!empty($errores)) {
    echo "<div class='container mt-4'><div class='alert alert-danger'><ul>";
    foreach ($errores as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul></div></div>";
    exit;
}

// Formato fecha para MySQL (de datetime-local a datetime)
$fecha_solicitada = str_replace("T", " ", $fecha_solicitada);

// 1. Verificar si el cliente existe POR SU EMAIL
$sqlCliente = "SELECT * FROM clientes WHERE email = '$email'";
$resultCliente = $mysqli->query($sqlCliente);

if ($resultCliente->num_rows == 0) {
    $sqlInsertCliente = "INSERT INTO clientes (nombre, email, telefono) VALUES ('$nombre', '$email', '$telefono')";
    if ($mysqli->query($sqlInsertCliente)) {
        $cliente_id = $mysqli->insert_id;
        $nombre_real = $nombre;
    } else {
        echo "<div class='alert alert-danger'>Ocurrió un error al registrar el cliente. Inténtalo de nuevo más tarde.</div>";
        exit;
    }
} else {
    $cliente = $resultCliente->fetch_assoc();
    $cliente_id = $cliente['id'];
    $nombre_real = $cliente['nombre'];
}

// 2. Buscar vehículo por matrícula
$sqlVehiculo = "SELECT * FROM vehiculos WHERE matricula = '$matricula'";
$resultVehiculo = $mysqli->query($sqlVehiculo);

if ($resultVehiculo->num_rows > 0) {
    $vehiculo = $resultVehiculo->fetch_assoc();
    $vehiculo_id = $vehiculo['id'];

    // Validar que los datos coincidan
    if (
        $vehiculo['marca'] !== $marca ||
        $vehiculo['modelo'] !== $modelo ||
        $vehiculo['año'] != $anio
    ) {
        echo "<div class='alert alert-danger'>
                La matrícula <strong>$matricula</strong> ya está registrada con datos distintos:<br>
                Registrado como <em>{$vehiculo['marca']} {$vehiculo['modelo']} {$vehiculo['año']}</em>.<br>
                No se puede usar con <em>$marca $modelo $anio</em>.
              </div>";
        exit;
    }
} else {
    // Insertar vehículo nuevo
    $sqlInsertVeh = "INSERT INTO vehiculos (marca, modelo, año, matricula)
                     VALUES ('$marca', '$modelo', '$anio', '$matricula')";
    if ($mysqli->query($sqlInsertVeh)) {
        $vehiculo_id = $mysqli->insert_id;
    } else {
        echo "<div class='alert alert-danger'>
                Error al insertar vehículo: " . $mysqli->error . "
              </div>";
        exit;
    }
}

// 3. Verificar o insertar relación cliente-vehículo en la tabla clientes_vehiculos
$sqlRelacion = "SELECT * FROM clientes_vehiculos WHERE id_cliente = $cliente_id AND id_vehiculo = $vehiculo_id";
$resultRelacion = $mysqli->query($sqlRelacion);

if ($resultRelacion->num_rows == 0) {
    $sqlInsertRelacion = "INSERT INTO clientes_vehiculos (id_cliente, id_vehiculo) VALUES ($cliente_id, $vehiculo_id)";
    if (!$mysqli->query($sqlInsertRelacion)) {
        echo "<div class='alert alert-danger'>Error al asociar cliente y vehículo: " . $mysqli->error . "</div>";
        exit;
    }
}

// 4. Insertar solicitud de cita
$sqlSolicitud = "INSERT INTO solicitudes_cita (id_cliente, id_vehiculo, fecha_solicitada, descripcion_cliente, solicitante_nombre) 
                 VALUES ($cliente_id, $vehiculo_id, '$fecha_solicitada', '$descripcion_cliente', '$nombre')";

if ($mysqli->query($sqlSolicitud)) {
     echo '
    <link rel="stylesheet" href="styleformulario.css">
    <div class="mensaje-exito">
        <h2>Solicitud registrada con éxito</h2>
        <p>La solicitud de cita ha sido registrada correctamente.</p>';

    if ($nombre !== $nombre_real) {
        echo "<p style='color: #856404; font-weight: bold;'>Atención: La cita ha sido registrada para <strong>$nombre_real</strong>, pero el formulario fue llenado por <strong>$nombre</strong>.</p>";
    }

    echo '<p>Por favor, <strong>no refresques ni vuelvas atrás</strong> para evitar enviar el formulario de nuevo.</p>
    </div>';

    header("refresh:5; url=formulario_cliente.html");
    exit;
} else {
    die("Error al registrar la solicitud de cita: " . $mysqli->error);
}

$mysqli->close();
?>
