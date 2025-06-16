<!DOCTYPE html>
<html lang="es" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">

<?php include("maquetacion/head.php"); 
$mecanicos = getMecanicos();
$clientes = getClientes();?>

<body>
    <div class="layout-wrapper">
        
        <!-- Sidebar -->
        <?php include("maquetacion/menu.php"); ?>

        <div class="page-content">

            <!-- Topbar -->
            <?php include("maquetacion/topbar.php"); ?>

            <!-- Formulario -->
            <div class="px-3">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Añadir Cita</h1>
                </div>

                <form action="modulo_citas_insert.php" method="post" id="form_cita">
                    <div class="row mb-3">  
                        <div class="col-md-6">
                            <label for="cliente">Seleccionar Cliente</label>
                            <span id="cliente_error" class="text-danger"></span>
                            <select name="cliente" id="cliente" class="form-control select2" required>
                            <option value="">-- Seleccione un cliente --</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>"><?= $cliente['nombre'] ?>&nbsp;// &nbsp;<?= $cliente['email'] ?></option>
                            <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="mecanico">Seleccionar Mecánico</label>
                            <span id="mecanico_error" class="text-danger"></span>
                            <select name="mecanico" id="mecanico" class="form-control select2">
                                <option value="">-- Seleccione un mecánico --</option>
                                <?php foreach ($mecanicos as $mecanico): ?>
                                    <option value="<?php echo $mecanico['id']; ?>">
                                        <?php echo $mecanico['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="marca" class="form-label">Marca</label>
                            <span id="marca_error" class="text-danger"></span>
                            <input type="text" class="form-control" id="marca" name="marca" required>                           
                        </div>
                        <div class="col-md-3">
                            <label for="modelo" class="form-label">Modelo</label>
                            <span id="modelo_error" class="text-danger"></span>
                            <input type="text" class="form-control" id="modelo" name="modelo" required>
                        </div>
                        <div class="col-md-3">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <span id="matricula_error" class="text-danger"></span>
                            <input type="text" class="form-control" id="matricula" name="matricula" required>
                        </div>
                          <div class="col-md-3">
                            <label for="anio_vehiculo" class="form-label">Año del vehiculo</label>
                            <span id="anio_vehiculo_error" class="text-danger"></span>
                            <input type="text" class="form-control" id="anio_vehiculo" name="anio_vehiculo" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha de la Cita</label>
                            <span id="fecha_error" class="text-danger"></span>
                            <input type="date" class="form-control" id="fecha" name="fecha" required min="<?= date('Y-m-d') ?>"required> 
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado</label>
                            <span id="estado_error" class="text-danger"></span>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="">-- Seleccione estado --</option>
                                <option value="en revision">En revision</option>
                                
                            </select>                            
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción de la Cita</label>
                        <span id="descripcion_error" class="text-danger"></span>
                        <textarea class="form-control" id="descripcion" name="descripcion_cliente" rows="3"></textarea>
                        
                    </div>

                    <button type="button" id="btnform1" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Añadir
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <?php include("maquetacion/footer.php"); ?>
        </div>
    </div>

    <!-- Scripts -->
    <?php include("maquetacion/scripts.php"); ?>
   
    <script>
    $(document).ready(function () {
        $("#btnform1").click(function () {
            let error = 0;

            // Obtener valores
            let cliente = $("#cliente").val().trim();
            let mecanico = $("#mecanico").val().trim();
            let marca = $("#marca").val().trim();
            let modelo = $("#modelo").val().trim();
            let matricula = $("#matricula").val().trim();
            let anio_vehiculo = $("#anio_vehiculo").val().trim();
            let fecha = $("#fecha").val().trim();
            let estado = $("#estado").val().trim();
            let descripcion_cliente = $("#descripcion").val().trim();

            // Limpiar errores anteriores
            $(".text-danger").html("");
            $(".form-control, .form-select").removeClass("borderError");

            // Validaciones
            if (cliente === "") {
                error = 1;
                $("#cliente_error").html("Debe introducir un cliente");
                $("#cliente").addClass("borderError");
            }
            
            if (mecanico === "") {
                error = 1;
                $("#mecanico_error").html("Debe introducir un mecánico");
                $("#mecanico").addClass("borderError");
            }
            
            if (marca === "") {
                error = 1;
                $("#marca_error").html("Debe introducir una marca");
                $("#marca").addClass("borderError");
            }
            if (modelo === "") {
                error = 1;
                $("#modelo_error").html("Debe introducir un modelo");
                $("#modelo").addClass("borderError");
            }
            if (matricula === "") {
                error = 1;
                $("#matricula_error").html("Debe introducir una matrícula");
                $("#matricula").addClass("borderError");
            }
            if (anio_vehiculo === "") {
                error = 1;
                $("#anio_vehiculo_error").html("Debe introducir un año");
                $("#anio_vehiculo").addClass("borderError");
            }
            if (fecha === "") {
                error = 1;
                $("#fecha_error").html("Debe introducir una fecha");
                $("#fecha").addClass("borderError");
            }
            if (estado === "") {
                error = 1;
                $("#estado_error").html("Debe seleccionar un estado");
                $("#estado").addClass("borderError");
            }
            if (descripcion_cliente === "") {
                error = 1;
                $("#descripcion_error").html("Debe introducir una descripción");
                $("#descripcion").addClass("borderError");
            }

            // Enviar si no hay errores
            if (error === 0) {
                $("#form_cita").submit();
            }
        });
    });
    </script>
</body>
</html>
