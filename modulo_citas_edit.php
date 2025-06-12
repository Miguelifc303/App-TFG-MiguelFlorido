<?php
include("maquetacion/head.php");
include("db.php");

// Validar ID
if (!isset($_GET['solicitud_id'])) {
    echo "ID no válido.";
    exit;
}

$id = $_GET['solicitud_id'];
$solicitud = getSolicitudById($id); 
if (!$solicitud) {
    echo "Solicitud no encontrada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">

<body>
    <div class="layout-wrapper">

        <!-- ========== Left Sidebar ========== -->
        <?php include("maquetacion/menu.php"); ?>

        <!-- Start Page Content here -->
        <div class="page-content">

            <!-- ========== Topbar Start ========== -->
            <?php include("maquetacion/topbar.php"); ?>

            <!-- Content -->
            <div class="px-3">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Editar Solicitud de Cita</h1>
                </div>

                <form action="modulo_citas_update.php" method="post">
                     <!-- Campo oculto para enviar el ID de la solicitud -->
                    <input type="hidden" name="solicitud_id" value="<?php echo $id; ?>">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" class="form-control" id="cliente" name="cliente" value="<?php echo $solicitud['cliente_nombre']; ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="vehiculo" class="form-label">Vehículo</label>
                            <input type="text" class="form-control" id="vehiculo" name="vehiculo" value="<?php echo $solicitud['vehiculo_marca'] . " " . $solicitud['vehiculo_modelo'] . " " . $solicitud['vehiculo_matricula']; ?>" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha de la Cita</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $solicitud['fecha']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" value="<?php echo ucfirst($solicitud['estado']); ?>" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion_cliente" rows="3" required><?php echo $solicitud['descripcion_cliente']; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Guardar Cambios
                    </button>
                </form>

            <!-- Footer Start -->
            <?php include("maquetacion/footer.php"); ?>

        </div> <!-- End Page content -->
    </div> <!-- End wrapper -->

    <?php include("maquetacion/scripts.php"); ?>

</body>
</html>
