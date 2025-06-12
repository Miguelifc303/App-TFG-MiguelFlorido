<?php
include("db.php");

// Verificar si se pasó el ID de la cita
if (!isset($_GET['id'])) {
    echo "No se ha proporcionado un ID válido de la cita.";
    exit();
}

$cita_id = $_GET['id'];

// Obtener los detalles de la cita
$query = "
    SELECT 
        c.id,
        s.id AS id_solicitud,
        cl.nombre AS cliente,
        v.marca, v.modelo, v.matricula,
        u.nombre AS mecanico,
        c.fecha,
        c.descripcion_cliente,
        c.estado_cita,
        c.veredicto_mecanico
    FROM citas c
    LEFT JOIN solicitudes_cita s ON c.id_solicitud = s.id
    LEFT JOIN clientes cl ON c.id_cliente = cl.id
    LEFT JOIN vehiculos v ON c.id_vehiculo = v.id
    LEFT JOIN usuarios u ON c.id_mecanico = u.id
    WHERE c.id = ?
";
if ($stmt = mysqli_prepare($mysqli, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $cita_id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) > 0) {
        $cita = mysqli_fetch_assoc($resultado);
    } else {
        echo "Cita no encontrada.";
        exit();
    }
} else {
    echo "Error al obtener los datos de la cita.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">

<?php include("maquetacion/head.php"); ?>

<body>

    <!-- Begin page -->
    <div class="layout-wrapper">

        <!-- ========== Left Sidebar ========== -->
        <?php include("maquetacion/menu.php"); ?>

        <!-- Start Page Content here -->
        <div class="page-content">

            <!-- ========== Topbar Start ========== -->
            <?php include("maquetacion/topbar.php"); ?>
            <!-- ========== Topbar End ========== -->

            <!-- Content -->
            <div class="px-3">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Editar Cita Asignada</h1>
                </div>

                <!-- Formulario para editar el veredicto -->
                <form action="modulo_citas_asignadas_update.php" method="post">
                    <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" class="form-control" id="cliente" value="<?php echo $cita['cliente']; ?>" >
                        </div>

                        <div class="col-md-6">
                            <label for="vehiculo" class="form-label">Vehículo</label>
                            <input type="text" class="form-control" id="vehiculo" value="<?php echo $cita['marca'] . ' ' . $cita['modelo'] . ' ' . $cita['matricula']; ?>" >
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_cita" class="form-label">Fecha Cita</label>
                            <input type="text" class="form-control" id="fecha_cita" value="<?php echo $cita['fecha']; ?>" >
                        </div>

                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" value="<?php echo ucfirst($cita['estado_cita']); ?>" >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion_cliente" class="form-label">Descripción Cliente</label>
                        <textarea class="form-control" id="descripcion_cliente" rows="3" ><?php echo $cita['descripcion_cliente']; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="veredicto_mecanico" class="form-label">Veredicto del Mecánico</label>
                        <textarea class="form-control" id="veredicto_mecanico" name="veredicto_mecanico" rows="3" required><?php echo $cita['veredicto_mecanico']; ?></textarea>
                    </div>

                    <!-- Botón para guardar el veredicto -->
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Guardar Veredicto
                    </button>
                </form>
            </div> <!-- End Content -->

            <!-- Footer Start -->
            <?php include("maquetacion/footer.php"); ?>
            <!-- end Footer -->

        </div> <!-- End Page content -->
    </div> <!-- End wrapper -->

    <!-- App js -->
    <?php include("maquetacion/scripts.php"); ?>

</body>
</html>
