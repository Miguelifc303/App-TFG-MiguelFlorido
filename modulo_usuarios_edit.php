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
                    <h1 class="h2">Usuarios - Editar</h1>
                    <a href="modulo_usuarios_list.php" class="btn btn-primary">Volver</a>
                </div>

                <?php
                    $user = getById("usuarios", $_GET["id"]);
                ?>

                <div class="col-md-6 col-lg-4">
                    <form action="#" method="post" enctype="multipart/form-data" id="form1">
                        <input type="hidden" name="id" value="<?php echo $user["id"]; ?>">

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <span id="nombre_error" class="text-danger"></span>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $user["nombre"]; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <span id="password_error" class="text-danger"></span>
                            <input type="text" class="form-control" id="password" name="password" value="<?php echo $user["password"]; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <span id="email_error" class="text-danger"></span>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user["email"]; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <span id="telefono_error" class="text-danger"></span>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $user["telefono"]; ?>">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="id_rol" class="form-label">Rol</label>
                            <span id="id_rol_error" class="text-danger"></span>
                            <select class="form-control" id="id_rol" name="id_rol">
                                <option value="">--Seleccione una opción--</option>
                                <?php echo SelectOptions("roles", "id", "rol"); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <input type="button" class="btn btn-info w-100" value="Aceptar" id="btnform1">
                        </div>
                    </form>
                </div>

            </div> <!-- End Content -->

            <!-- Footer Start -->
            <?php include("maquetacion/footer.php"); ?>
            <!-- end Footer -->

        </div>
        <!-- End Page content -->

    </div>
    <!-- END wrapper -->

    <!-- App js -->
    <?php include("maquetacion/scripts.php"); ?>

    <!-- Script de validación y envío AJAX -->
    <script>
        $(document).ready(function () {
            $("#btnform1").click(function () {
                let id_rol = $("#id_rol").val();
                let nombre = $("#nombre").val();
                let password = $("#password").val();
                let email = $("#email").val();
                let telefono = $("#telefono").val();
                let error = 0;

                $(".text-danger").html("");
                $(".form-control").removeClass("borderError");

                if (id_rol === "") {
                    error = 1;
                    $("#id_rol_error").html("Debe seleccionar un rol");
                    $("#id_rol").addClass("borderError");
                }
                if (nombre === "") {
                    error = 1;
                    $("#nombre_error").html("Debe introducir un nombre de usuario");
                    $("#nombre").addClass("borderError");
                }
                if (password === "") {
                    error = 1;
                    $("#password_error").html("Debe introducir una contraseña");
                    $("#password").addClass("borderError");
                }
                if (email === "") {
                    error = 1;
                    $("#email_error").html("Debe introducir una dirección de correo");
                    $("#email").addClass("borderError");
                }
                if (telefono === "") {
                    error = 1;
                    $("#telefono_error").html("Debe introducir un telefono");
                    $("#telefono").addClass("borderError");
                }

                if (error === 0) {
                    $.ajax({
                        data: $("#form1").serialize(),
                        method: "POST",
                        url: "modulo_usuarios_update.php",
                        success: function (result) {
                            if (result == 1) {
                                Swal.fire({
                                    title: "Datos actualizados correctamente!",
                                    icon: "success",
                                    timer: 2000,
                                    showConfirmButton: false,
                                    willClose: () => {
                                        window.location.href = "modulo_usuarios_list.php";
                                    }
                                });
                            } else {
                                Swal.fire("Error", "No se pudo actualizar el usuario", "error");
                            }
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>
