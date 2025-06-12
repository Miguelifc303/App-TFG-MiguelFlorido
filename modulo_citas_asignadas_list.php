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
                    <h1 class="h2">Citas Asignadas</h1>
                </div>

                <table class="table datatabla">
                    <thead>
                        <tr>
                            <th>Solicitud</th> 
                            <th>Cliente</th>  
                            <th>Vehículo</th>
                            <th>Estado</th>
                            <th>Fecha Cita</th>
                            <th>Descripción Cita</th>
                           
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id_usuario = $_SESSION['id_usuario'];
                        $citas = getCitasAsignadas($id_usuario);

                        if (count($citas) > 0) {
                            foreach ($citas as $cita) {
                        ?>
                                <tr>
                                    <td><?php echo $cita["id_solicitud"]; ?></td>
                                    <td><?php echo $cita["cliente"]; ?></td>
                                    <td><?php echo $cita["marca"] . " " . $cita["modelo"] . " " . $cita["matricula"]; ?></td>
                                    <td>
                                        <?php if ($cita['estado_cita'] == 'En revision'): ?>
                                            <span class="badge bg-warning">Aprobada</span>
                                        <?php elseif ($cita['estado_cita'] == 'Finalizada'): ?>
                                            <span class="badge bg-success">Finalizada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo $cita['fecha_cita']; ?></td>
                                    <td><?php echo $cita['descripcion_cita']; ?></td>
                                    <td>
                                        <?php if ($cita['estado_cita'] == 'pendiente'): ?>
                                            <div class="alert alert-warning d-flex align-items-center p-2" style="max-width: 100px;">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                Asignar mecánico
                                            </div>
                                    </td>        
                                    <td>
                                            <?php else: ?>
                                                <a href="#" class="btn btn-sm btn-danger borrar-cita" data-id="<?php echo $cita['cita_id']; ?>" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                                <a href="modulo_citas_asignadas_edit.php?id=<?php echo $cita['cita_id']; ?>" class="btn btn-info btn-sm" title="Editar">
                                                    <i class="bi bi-pencil"></i> 
                                                </a>

                                            <?php endif; ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><tr><td colspan='7' class='text-center'>No hay citas asignadas</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div> 

            <!-- Footer Start -->
            <?php include("maquetacion/footer.php"); ?>
            <!-- Footer End -->

        </div>
        <!-- End Page content -->
    </div>
    <!-- END wrapper -->

    <!-- App JS -->
    <?php include("maquetacion/scripts.php"); ?>

    <script>
$(document).ready(function(){
    $(".borrar-cita").click(function(e){
        e.preventDefault();

        let id = $(this).attr('data-id');
        let fila = $(this).closest("tr");
        console.log("ID que se enviará al servidor:", id);
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "¿Desea eliminar esta cita?",
            text: "No hay vuelta atrás.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar!",
            cancelButtonText: "Cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "modulo_citas_asignadas_delete.php",
                    method: "POST",
                    data: {id: id},
                    success: function(response){
                        if(response == 1){
                            swalWithBootstrapButtons.fire(
                                "¡Eliminado!",
                                "La cita ha sido eliminada.",
                                "success"
                            );
                            fila.fadeOut();
                        } else {
                            swalWithBootstrapButtons.fire(
                                "Error",
                                "No se pudo eliminar la cita.",
                                "error"
                            );
                        }
                    },
                    error: function(){
                        swalWithBootstrapButtons.fire(
                            "Error",
                            "Error en la solicitud AJAX.",
                            "error"
                        );
                    }
                });
            }
        });
    });
});
</script>

</body>
</html>
