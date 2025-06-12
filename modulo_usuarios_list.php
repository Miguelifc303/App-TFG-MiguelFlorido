<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">

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
                    <h1 class="h2">Usuarios</h1>
                    <div class="d-flex align-items-center gap-2">
                        <a href="modulo_usuarios_new.php" class="btn btn-primary">Nuevo</a>
                        <a href="#" class="btn btn-success" id="exportar">Exportar&nbsp;<i class="fa-regular fa-file-excel"></i></a>
                    </div>
                </div>

                <?php
                $excel = '<table><thead><tr><th>Id</th><th>Nombre</th><th>Email</th><th>Telefono</th><th>Rol</th></tr></thead><tbody>';                  
                ?>

                <table class="table datatabla">
                    <thead>
                        <tr>
                            <th>Id</th> 
                            <th>Nombre</th>  
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Obtiene los usuarios con join para obtener el nombre del rol
                    $usuarios = getAllVInner("usuarios","roles","id_rol","id");
                    
                    if(count($usuarios) > 0){
                        foreach($usuarios as $u){
                            ?>
                                <tr>
                                    <td><?php echo $u["id1"];?></td> 
                                    <td><?php echo $u["nombre"];?></td>  
                                    <td><?php echo $u["email"];?></td>
                                    <td><?php echo $u["telefono"];?></td>
                                    <td><?php echo $u["rol"];?></td>
                                    <td>
                                        <a href="modulo_usuarios_edit.php?id=<?php echo $u["id1"];?>" class="btn btn-info btn-sm">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        &nbsp;&nbsp;
                                        <a href="#" data-id="<?php echo $u["id1"];?>" class="btn btn-danger btn-sm borrar">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            $excel .= '<tr>';
                            $excel .= '<td>' . $u["id1"] . '</td>';
                            $excel .= '<td>' . $u["nombre"] . '</td>';
                            $excel .= '<td>' . $u["email"] . '</td>';
                            $excel .= '<td>' . $u["telefono"] . '</td>';
                            $excel .= '<td>' . $u["rol"] . '</td>';
                            $excel .= '</tr>';
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th> 
                            <th>Nombre</th> 
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>

                <?php
                $excel .= '</tbody></table>';    
                ?>

                <form action="ficheroExcel.php" method="post" enctype="multipart/form-data" id="formExportar">
                    <input type="hidden" value="Usuarios" name="nombreFichero">
                    <input type="hidden" value="<?php echo htmlspecialchars($excel, ENT_QUOTES); ?>" name="datos_a_enviar">
                </form>

            </div> <!-- End Content -->

            <!-- Footer Start -->
            <?php include("maquetacion/footer.php"); ?>
            <!-- end Footer -->

        </div>
    </div>
    <?php include("maquetacion/scripts.php"); ?>

    <script>
        $("#exportar").click(function(){
            $("#formExportar").submit();
        });

        $(".borrar").click(function(){
            let id = $(this).attr('data-id');
            let padre = $(this).parent().parent();
            
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            
            swalWithBootstrapButtons.fire({
                title: "Desea eliminar al usuario?",
                text: "No hay vuelta atrás!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, borrar!",
                cancelButtonText: "No, mantener!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        data: {id: id},
                        method: "POST",
                        url: "modulo_usuarios_delete.php", 
                        success: function(result){
                            if(result == 1){
                                swalWithBootstrapButtons.fire({
                                    title: "Eliminado!",
                                    text: "Usuario dado de baja",
                                    icon: "success"
                                });
                                padre.hide();
                            } else {
                                swalWithBootstrapButtons.fire({
                                    title: "No Eliminado!",
                                    text: "Usuario NO dado de baja",
                                    icon: "error"
                                });
                            }
                        }
                    });
                }
            });
        });
    </script>   

</body>
</html>
