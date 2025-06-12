<div class="navbar-custom">
                <div class="topbar">
                    <div class="topbar-menu d-flex align-items-center gap-lg-2 gap-1">

                        <!-- Brand Logo -->
                        <div class="logo-box">
                            <!-- Brand Logo Light -->
                            <a href="index.php" class="logo-light">
                                <img src="assets/images/logo-light.png" alt="logo" class="logo-lg" height="32">
                                <img src="assets/images/logo-light-sm.png" alt="small logo" class="logo-sm" height="32">
                            </a>

                            <!-- Brand Logo Dark -->
                            <a href="index.php" class="logo-dark">
                                <img src="assets/images/logo-dark.png" alt="dark logo" class="logo-lg" height="32">
                                <img src="assets/images/logo-dark-sm.png" alt="small logo" class="logo-sm" height="32">
                            </a>
                        </div>

                        <!-- Sidebar Menu Toggle Button -->
                        <button class="button-toggle-menu waves-effect waves-light rounded-circle">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </div>

                    <ul class="topbar-menu d-flex align-items-center gap-2">




                        <li class="nav-link waves-effect waves-light" id="theme-mode">
                            <i class="bx bx-moon font-size-24"></i>
                        </li>
                        
                        
                        <!-- AQUI SE EDITA EL PERFIL. AQUÍ QUERRÍA QUE APARECIESE EL USUARIO QUE HA INICIADO SESION-->
                        <li class="dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="ms-1 d-none d-md-inline-block">
                                    <?php echo $_SESSION["usuario"];?> <i class="mdi mdi-chevron-down"></i>
                                </span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                           
                                <!-- item-->
                                <a href="logout.php" class="dropdown-item notify-item">
                                    <i data-lucide="log-out" class="font-size-16 me-2"></i>
                                    <span>Cerrar sesión</span>
                                </a>

                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
