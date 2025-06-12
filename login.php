<!DOCTYPE html>
<html lang="es" data-bs-theme="light" data-menu-color="light" data-topbar-color="dark">

<head>
    <meta charset="utf-8">
    <title>Log In | Scoxe - Responsive Bootstrap 5 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Myra Studio" name="author">

    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap CSS -->
    <link href="assets/css/style.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">

    <script src="assets/js/config.js"></script>
</head>

<body>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow-lg rounded p-4 w-50">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <img class="mb-3" src="imagenes/login_mecanico.jpg" width="200" height="200">
                    <h1 class="h5">Bienvenido Mecanic4You</h1>
                    <p class="text-muted">Introduce tu correo y contraseña para acceder al panel de administración</p>
                </div>

                <div class="col-lg-12">
                    <form action="#">
                        <div class="mb-3">
                            <label class="form-label" for="usuario">Usuario</label>
                            <input class="form-control" type="text" id="username" required placeholder="Usuario">
                            <small id="username_error" class="text-danger"></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Contraseña</label>
                            <input class="form-control" type="password" required id="password" placeholder="Contraseña">
                            <small id="pass_error" class="text-danger"></small>
                        </div>

                        <div id="errorV" class="text-danger mb-3 text-center"></div>
                        
                        <div class="text-center">
                            <button class="btn btn-primary w-100 py-2" type="button" id="btnValidar">Iniciar Sesión</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- App JS -->
    <script src="assets/js/vendor.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#btnValidar").click(function () {
                let username = $("#username").val();
                let password = $("#password").val();
                let error = 0;

                if (username == "") {
                    error = 1;
                    $("#username_error").html("Debe introducir un nombre de usuario");
                    $("#username").addClass("borderError");
                }
                if (password == "") {
                    error = 1;
                    $("#pass_error").html("Debe introducir una contraseña");
                    $("#password").addClass("borderError");
                }

                if (error == 0) {
                    $.ajax({
                        data: { username: username, password: password },
                        method: "POST",
                        url: "verificar.php",
                        success: function (result) {
                            
                            if (result == 0) {
                                $("#errorV").html("Usuario o contraseña incorrectos");
                                $("#username").val('');
                                $("#password").val('');
                            } else {
                                location.href = "index.php";
                            }
                        }
                    });
                }
            });

            $("#username, #password").on('keyup', function () {
                if ($(this).val().length > 0) {
                    $(this).next("small").html("");
                    $(this).removeClass("borderError");
                }
            });
        });
    </script>

</body>

</html>
