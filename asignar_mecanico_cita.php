<!DOCTYPE html>
<html lang="es" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">

<?php include("maquetacion/head.php"); ?>

<body>

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
                    <h1 class="h2">Asignar Mecánico</h1>
                </div>

                <?php
                // Obtener el id_solicitud desde la URL
                $solicitud_id = isset($_GET['solicitud_id']) ? $_GET['solicitud_id'] : null;
                $cita = null;  

                if ($solicitud_id) {
                    // Obtener los datos de la solicitud
                    $solicitud = getSolicitudByIdMecanico($solicitud_id); // Esta función debe devolver los datos de la solicitud (cliente, id_vehiculo, etc.)

                    if ($solicitud) {
                        $id_cliente = $solicitud['id_cliente'];

                        $cliente = getClienteById($id_cliente); // Esta función obtiene los datos del cliente

                        $id_vehiculo = $solicitud['id_vehiculo'];

                        $vehiculo = getVehiculoById($id_vehiculo); // Esta función obtiene los datos del vehículo

                        $mecanicos = getMecanicos();

                        $cita = getCitaBySolicitudId($solicitud_id);  // Esta función debe obtener la cita asociada a la solicitud

                    } else {
                        echo "No se encontró la solicitud con el ID: " . $solicitud_id;
                    }
                } else {
                    echo "Solicitud ID no especificado.";
                }
                ?>

                <?php if (!$cita): ?>
                    <form action="modulo_asignar_mecanico.php" method="POST">
                        <div class="form-group">
                            <label for="id_solicitud">Solicitud ID</label>
                            <input type="text" class="form-control" id="id_solicitud" name="id_solicitud" value="<?php echo $solicitud_id; ?>" readonly>
                        </div>

                        <!-- Mostrar los datos de cliente -->
                        <div class="form-group">
                            <label for="cliente">Cliente</label>
                            <input type="text" class="form-control" id="cliente" name="cliente" 
                                value="Solicitante: <?php echo $solicitud['solicitante_nombre']; ?> - Nombre: <?php echo $cliente['nombre']; ?> - Teléfono: <?php echo $cliente['telefono']; ?> - Email: <?php echo $cliente['email']; ?>" readonly>
                        </div>

                        <!-- Mostrar los datos del vehículo -->
                        <div class="form-group">
                            <label for="vehiculo">Vehículo</label>
                            <input type="text" class="form-control" id="vehiculo" name="vehiculo" value="<?php echo $vehiculo['marca'] . " " . $vehiculo['modelo'] . " " . $vehiculo['matricula']; ?>" readonly>
                        </div>

                        <!-- Seleccionar el mecánico -->
                        <div class="form-group">
                            <label for="mecanico_id">Seleccionar Mecánico</label>
                            <select name="mecanico_id" id="mecanico_id" class="form-control select2">
                                <option value="" selected disabled>-- Seleccione un mecánico --</option>
                                <?php foreach ($mecanicos as $mecanico): ?>
                                    <option value="<?php echo $mecanico['id']; ?>">
                                        <?php echo $mecanico['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Asignar Mecánico</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-success">La cita ya ha sido creada.</div>
                <?php endif; ?>

            </div> <!-- End Content -->

            <!-- Footer Start -->
            <?php include("maquetacion/footer.php"); ?>
        </div>
    </div> 
    <?php include("maquetacion/scripts.php"); ?>

</body>
</html>
