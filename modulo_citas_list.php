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
                    <h1 class="h2">Citas</h1>
                    <div class="d-flex align-items-center gap-2">
                        <a href="modulo_citas_new.php" class="btn btn-primary">Nueva Cita</a>
                        <a href="#" class="btn btn-success" id="exportar">Exportar&nbsp;<i class="fa-regular fa-file-excel"></i></a>                    </div>
                </div>

               <?php
                $excel = '<table><thead><tr>
                <th>Id Solicitud</th>
                <th>Cliente</th>
                <th>Vehículo</th>
                <th>Estado</th>
                <th>Mecánico</th>
                <th>Fecha Cita</th>
                <th>Descripción Cita</th>
                <th>Veredicto Mecánico</th>
                </tr></thead><tbody>';
                ?>

<table class="table datatabla">
    <thead>
        <tr>
            <th>Id Solicitud</th>
            <th>Cliente</th>
            <th>Vehículo</th>
            <th>Estado</th>
            <th>Mecánico</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $citas = getAllCitas(); // Obtener datos de las citas
    if (count($citas) > 0) {
        foreach ($citas as $cita) {
            $id = !empty($cita['id_solicitud']) ? $cita['id_solicitud'] : $cita['cita_id'];

            $tipo = !empty($cita['id_solicitud']) ? 'solicitud' : 'cita'
            ?>
                <tr>
                    <td><?php echo $cita["id_solicitud"];?></td>
                    <td><?php echo $cita["cliente"];?></td>
                    <td><?php echo $cita["marca"] . " " . $cita["modelo"] . " " . $cita["matricula"];?></td>
                    <?php
                        // Determinar etiqueta y clase según el estado
                        if ($cita['estado_solicitud'] === 'pendiente') {
                            $label = 'Pendiente';
                            $badge = 'danger';    // rojo
                        } elseif ($cita['estado_solicitud'] === 'confirmada' && $cita['estado_cita'] !== 'Finalizada') {
                            $label = 'En revisión';
                            $badge = 'warning';   // amarillo
                        } elseif ($cita['estado_cita'] === 'Finalizada') {
                            $label = 'Finalizada';
                            $badge = 'success';   // verde
                        } else {
                            // Cubrimos también el caso donde estado_solicitud='confirmada' y estado_cita='En revisión'
                            $label = 'En revisión';
                            $badge = 'warning';
                        }
                    ?>
                    <td>
                        <span class="badge bg-<?= $badge ?>">
                            <?= $label ?>
                        </span>
                    </td>

                    <td><?php echo is_null($cita['mecanico']) ? 'No asignado' : $cita['mecanico'];?></td>
                    <td><?php echo $cita['fecha'] ? $cita['fecha'] : 'N/A';?></td>
                    <td><?php echo $cita['descripcion_cliente'] ? $cita['descripcion_cliente'] : 'N/A';?></td>
                    <td>
                        <?php if ($cita['estado_cita'] === 'Finalizada'): ?>
                            <a 
                            href="imprimir_cita.php?id=<?= $id ?>&tipo=<?= $tipo ?>" 
                            target="_blank" 
                            class="btn btn-secondary btn-sm" 
                            title="Imprimir Cita"
                            >
                                <i class="bi bi-printer"></i>
                            </a>

                            <a href="#" 
                                data-id="<?= $cita['cita_id'] ?>" 
                                data-tipo="cita" 
                                class="btn btn-danger btn-sm borrar" 
                                title="Eliminar Cita"
                            >
                                <i class="bi bi-trash"></i>
                            </a>

                        <?php elseif ($cita['estado_solicitud'] === 'pendiente'): ?>
                            <a 
                                href="modulo_citas_edit.php?solicitud_id=<?= $cita['id_solicitud'] ?>" 
                                class="btn btn-info btn-sm" 
                                title="Editar Cita"
                            >
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a 
                                href="asignar_mecanico_cita.php?solicitud_id=<?= $cita['id_solicitud'] ?>" 
                                class="btn btn-warning btn-sm" 
                                title="Asignar Mecánico"
                            >
                                <i class="bi bi-person-plus-fill"></i>
                            </a>

                            <a href="#" 
                                data-id="<?= $cita['id_solicitud'] ?>" 
                                data-tipo="solicitud" 
                                class="btn btn-danger btn-sm borrar" 
                                title="Eliminar Solicitud"
                            >
                                <i class="bi bi-trash"></i>
                            </a>

                        <?php endif; ?>
                    </td>
                </tr>
            <?php
            $estado_cita = '';
            if ($cita['estado_solicitud'] == 'pendiente') {
                $estado_cita = 'Pendiente';
            } elseif ($cita['estado_solicitud'] == 'confirmada' ) {
                $estado_cita = 'En revisión';
            }elseif ($cita['estado_cita'] == 'Finalizada') {
                $estado_cita = 'Finalizada';
            }
            $excel .= '<tr>';
            $excel .= '<td>' . $cita["id_solicitud"] . '</td>';
            $excel .= '<td>' . $cita["cliente"] . '</td>';
            $excel .= '<td>' . $cita["marca"] . " " . $cita["modelo"] . " " . $cita["matricula"] . '</td>';
            $excel .= '<td>' . $estado_cita . '</td>';
            $excel .= '<td>' . $cita["mecanico"] . '</td>';
            $excel .= '<td>' . $cita["fecha"] . '</td>';
            $excel .= '<td>' . $cita["descripcion_cliente"] . '</td>';
            $excel .= '<td>' . $cita["veredicto_mecanico"] . '</td>';
            $excel .= '</tr>';
        }
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <th>Id Solicitud</th> 
            <th>Cliente</th>  
            <th>Vehículo</th>
            <th>Estado</th>
            <th>Mecánico</th>
            <th>Fecha Cita</th>
            <th>Descripción Cita</th>
            
            <th>Acciones</th>
        </tr>
    </tfoot>
</table>

<?php
$excel .= '</tbody></table>';
?>

<form action="fichero_excel.php" method="post" enctype="multipart/form-data" id="formExportar">
    <input type="hidden" value="Citas" name="nombreFichero">
    <textarea name="datos_a_enviar" hidden><?php echo htmlspecialchars($excel); ?></textarea>

</form>

            </div> <!-- End Content -->

            <!-- Footer Start -->
            <?php include("maquetacion/footer.php"); ?>
            <!-- end Footer -->

        </div>
        <!-- End Page content -->
    </div>

    <?php include("maquetacion/scripts.php"); ?>

    <script>
         $("#exportar").click(function() {
            $("#formExportar").submit();
         });
         $(".borrar").click(function(e){
            e.preventDefault(); 
            let id = $(this).data('id');
            let tipo = $(this).data('tipo'); // 'cita' o 'solicitud'
            let fila = $(this).closest('tr');

            if (!id || !tipo) {
                Swal.fire("Error", "ID o tipo no válido", "error");
                return;
            }

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'modulo_citas_delete.php',
                        method: 'POST',
                        data: { id: id, tipo: tipo },
                        success: function(res) {
                            if (res.trim() == "1") {
                                swalWithBootstrapButtons.fire(
                                    "¡Eliminado!",
                                    "La " + (tipo === 'cita' ? "cita" : "solicitud") + " ha sido eliminada.",
                                    "success"
                                );
                                fila.fadeOut(); // Oculta la fila eliminada sin recargar
                            } else {
                                swalWithBootstrapButtons.fire(
                                    "Error",
                                    "No se pudo eliminar la " + (tipo === 'cita' ? "cita" : "solicitud"),
                                    "error"
                                );
                            }
                        },
                        error: function() {
                            swalWithBootstrapButtons.fire(
                                "Error",
                                "Hubo un problema al conectar con el servidor",
                                "error"
                            );
                        }
                    });
                }
            });
        });




    </script>

    

</body>
</html>