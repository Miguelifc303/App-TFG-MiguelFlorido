<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">

<?php include("maquetacion/head.php") ?>

<body>

  <div class="layout-wrapper">

    <!-- ========== Left Sidebar ========== -->
    <?php include("maquetacion/menu.php") ?>
    <div class="page-content">

      <!-- ========== Topbar Start ========== -->
      <?php include("maquetacion/topbar.php") ?>
      <!-- ========== Topbar End ========== -->

      <div class="px-3">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Usuarios - Nuevo</h1>
          <a href="modulo_usuarios_list.php" class="btn btn-primary">Volver</a>
        </div>

        <div class="col-4">
          <form action="#" method="post" enctype="multipart/form-data" id="form1">
            <div class="row">
              <div class="col-6 mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <span id="nombre_error" class="text-danger"></span>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre">
              </div>

              <div class="col-6 mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <span id="password_error" class="text-danger"></span>
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
              </div>
            </div>

            <div class="row">
              <div class="col-6 mb-3">
                <label for="email" class="form-label">E-mail</label>
                <span id="email_error" class="text-danger"></span>
                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail">
              </div>

              <div class="col-6 mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <span id="telefono_error" class="text-danger"></span>
                <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Teléfono">
              </div>
            </div>

            <div class="row">
              <div class="col-12 mb-3">
                <label for="id_rol" class="form-label">Rol</label>
                <span id="id_rol_error" class="text-danger"></span>
                <select class="form-control select2" id="id_rol" name="id_rol">
                  <option value="">--Seleccione una opción--</option>
                  <?php echo SelectOptions("roles", "id", "rol"); ?>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <input type="button" class="form-control btn btn-primary" value="Aceptar" id="btnform1">
            </div>
          </form>

        </div>

      </div> <!-- end content -->

      <!-- Footer Start -->
      <?php include("maquetacion/footer.php") ?>
      <!-- end Footer -->

    </div>

  </div>
  <?php include("maquetacion/scripts.php") ?>

  <script>
    $(document).ready(function() {
      $("#btnform1").click(function() {
        let id_rol = $("#id_rol").val();
        let nombre = $("#nombre").val();
        let password = $("#password").val();
        let email = $("#email").val();
        let telefono = $("#telefono").val();
        let error = 0;

        // Reset errores y estilos
        $(".text-danger").html("");
        $("input, select").removeClass("borderError");

        if (id_rol == "") {
          error = 1;
          $("#id_rol_error").html("Debe seleccionar un rol");
          $("#id_rol").addClass("borderError");
        }
        if (nombre == "") {
          error = 1;
          $("#nombre_error").html("Debe introducir un nombre");
          $("#nombre").addClass("borderError");
        }
        if (password == "") {
          error = 1;
          $("#password_error").html("Debe introducir una contraseña");
          $("#password").addClass("borderError");
        }
        if (email == "") {
          error = 1;
          $("#email_error").html("Debe introducir una dirección de correo");
          $("#email").addClass("borderError");
        }
        if (telefono == "") {
          error = 1;
          $("#telefono_error").html("Debe introducir un teléfono");
          $("#telefono").addClass("borderError");
        }

        if (error == 0) {
          $.ajax({
            data: $("#form1").serialize(),
            method: "POST",
            url: "modulo_usuarios_insert.php",
            success: function(result) {
              if (result > 1) {
                Swal.fire({
                  title: "Datos insertados correctamente!",
                  timer: 2000,
                  timerProgressBar: true,
                  didOpen: () => {
                    Swal.showLoading()
                  },
                  willClose: () => {}
                }).then(() => {
                  location.href = "modulo_usuarios_list.php";
                });
              } else {
                Swal.fire("No Insertado correctamente!");
              }
            }
          });
        }
      });
    });
  </script>
</body>

</html>
