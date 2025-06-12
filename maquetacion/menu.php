<div class="main-menu">
    <!-- Brand Logo -->
    <div class="logo-box">
 <!-- Brand Logo Light -->
        <a href="index.php">
            <img src="imagenes/logoTFG.png" alt="logo" height="92" style="padding-top: 20px;">
        </a>

    </div>

    <!-- Menu -->
    <div data-simplebar>
        <ul class="app-menu">

            <li class="menu-title">Menu Principal</li>

            <!-- Todos los roles tienen acceso a la página principal -->
            <li class="menu-item">
                <a href="index.php" class="menu-link waves-effect">
                    <span class="menu-icon"><i data-lucide="home"></i></span>
                    <span class="menu-text">Inicio</span>
                </a>
            </li>

            <!-- Solo Administrador y Recepcionista pueden acceder a la gestión de citas -->
            <?php if ($_SESSION["id_roles"] == 1 || $_SESSION["id_roles"] == 2): ?>
                <li class="menu-item">
                    <a href="modulo_citas_list.php" class="menu-link waves-effect">
                        <span class="menu-icon"><i data-lucide="calendar"></i></span>
                        <span class="menu-text">Citas</span>
                    </a>
                </li>
            <?php endif; ?>


            <!-- Solo el Mecánico verá las citas asignadas a él -->
            <?php if ($_SESSION["id_roles"] == 3): ?>
                <li class="menu-item">
                    <a href="modulo_citas_asignadas_list.php" class="menu-link waves-effect">
                        <span class="menu-icon"><i data-lucide="check-square"></i></span>
                        <span class="menu-text">Citas Asignadas</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Solo el Administrador puede ver la gestión de usuarios y roles -->
            <?php if ($_SESSION["id_roles"] == 1): ?>
                <li class="menu-item">
                    <a href="#menuConfiguracion" data-bs-toggle="collapse" class="menu-link waves-effect">
                        <span class="menu-icon"><i data-lucide="settings"></i></span>
                        <span class="menu-text">Configuración</span>
                    </a>
                    <div class="collapse" id="menuConfiguracion">
                        <ul class="sub-menu">
                            <li class="menu-item">
                                <a href="modulo_usuarios_list.php" class="menu-link">
                                    <span class="menu-text">Usuarios</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="modulo_roles_list.php" class="menu-link">
                                    <span class="menu-text">Roles</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="modulo_clientes_list.php" class="menu-link">
                                    <span class="menu-text">Clientes</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="modulo_vehiculos_list.php" class="menu-link">
                                    <span class="menu-text">Vehículos</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
            
            <?php if ($_SESSION["id_roles"] == 2): ?>
                <li class="menu-item">
                    <a href="modulo_clientes_list.php" class="menu-link waves-effect">
                        <span class="menu-icon"><i data-lucide="users"></i></span>
                        <span class="menu-text">Clientes</span>
                    </a>
                </li>
            <?php endif; ?>
    </ul>

        <div class="help-box">
            <h5 class="text-muted font-size-15 mb-3"></h5>
            <p class="font-size-13"><span class="font-weight-bold">Email:</span> <br> mecanic4you@gmail.com</p>
            <p class="mb-0 font-size-13"><span class="font-weight-bold">Servicio técnico:</span> <br> (+34) 633 61 23 29</p>
        </div>
    </div>
</div>
